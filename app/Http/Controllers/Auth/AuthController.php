<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegisteredEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\ResetPasswordMail;
use App\Mail\VerifyMail;
use App\Models\User;
use App\Models\UserVerify;
use App\Notifications\VerifyNotification;
use App\Traits\Loggable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    use Loggable;

    public function showLoginAdmin()
    {
        if (Auth::check()) return redirect()->route('admin.index');
        return view('admin.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $email = $request->email;
        $password = $request->password;
        $remember = $request->remember ? true : false;

        if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1], $remember)) {
            $user = Auth::user();
            $this->log("login", $user->id, $user->toArray(), User::class);

            \Log::notice("User Login: $user->name", $user->toArray());

            return redirect()->route('admin.index');
        } else {
            return redirect()->back()->withErrors([
                'email' => "Verdiğiniz bilgilerle eşleşen bir kullanıcı bulunamadı."
            ])
                // ->withInput()
                ->onlyInput("email", "remember");
        }
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {

            $user = Auth::user();

            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            if (!$user->is_admin && !$user->is_staff)
                return redirect()->route("front.index", ['locale' => config('app.locale')]);
            // return redirect("/");

            return redirect()->route("login");
        }
    }

    /**** FRONT ****/
    // Üye Olma
    public function showRegister()
    {
        if (Auth::user()) abort(404);
        $breadcrumbs = [
            [
                "name" => "",
                "link" => route('front.index')
            ],
            [
                "name" => __('front.register'),
                "link" => "#"
            ],
        ];
        $page_title = __('front.register') . ' | ' . config('app.name');
        return view("front.auth.register", compact('breadcrumbs', 'page_title'));
    }

    public function register(RegisterRequest $request)
    {
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->status = 0;
        $user->save();

        event(new UserRegisteredEvent($user));

        if ($user) {
            return redirect()->back()
                ->with([
                    'message' => 'Mailinizi onaylamanız için onay maili gönderilmiştir. Lütfen mail kutunuzu kontrol edin',
                    'message_type' => 'success'
                ]);
        } else {
            return redirect()->back()
                ->with('message', 'Hata')
                ->with('message_type', 'danger');
        }
    }

    public function verify(Request $request, string $locale, $token)
    {
        $verifyQuery = UserVerify::query()->with("user")->where("token", $token);
        $find = $verifyQuery->first();

        $now = Carbon::now();
        $difference = $now->diffInHours($find->created_at ?? '');

        if (!is_null($find) && $difference <= 1) {
            $user = $find->user;

            if (is_null($user->email_verified_at)) {
                $user->email_verified_at = now();
                $user->status = 1;
                $user->save();

                $verifyQuery->delete();
                $message = [
                    'type' => 'success',
                    'text' => "Emailiniz doğrulandı. <a href='" . route('front.login') . "'>Giriş</a> yapabilirsiniz."
                ];
            } else {
                $message = [
                    'type' => 'success',
                    'text' => "Emailiniz daha önce doğrulanmıştı. <a href='" . route('front.login') . "'>Giriş</a> yapabilirsiniz."
                ];
            }
            $breadcrumbs = [
                [
                    "name" => "",
                    "link" => route('front.index')
                ],
                [
                    "name" => __('front.register'),
                    "link" => "#"
                ],
            ];
            $page_title = __('front.register') . ' | ' . config('app.name');
            return view('front.auth.verify', compact('message', 'page_title', 'breadcrumbs'));
        } else {
            abort(404);
        }
    }

    // Giriş Yap
    public function showLoginUser()
    {
        if (Auth::user()) abort(404);
        $breadcrumbs = [
            [
                "name" => "",
                "link" => route('front.index')
            ],
            [
                "name" => __('front.login'),
                "link" => "#"
            ],
        ];
        $page_title = __('front.login') . ' | ' . config('app.name');
        return view("front.auth.login", compact('breadcrumbs', 'page_title'));
    }

    public function loginUser(LoginRequest $request)
    {
        $email = $request->email;
        $password = $request->password;
        $remember = $request->remember ? true : false;

        if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1], $remember)) {
            $user = Auth::user();
            $this->log("login", $user->id, $user->toArray(), User::class);

            \Log::notice("User Login: $user->name", $user->toArray());

            return to_route('front.index');
        } else {
            return redirect()->back()->withErrors([
                'email' => "Verdiğiniz bilgilerle eşleşen bir kullanıcı bulunamadı."
            ])
                // ->withInput()
                ->onlyInput("email", "remember");
        }
    }

    // Şifremi Unuttum
    public function showPasswordReset()
    {
        $breadcrumbs = [
            [
                "name" => "",
                "link" => route('front.index')
            ],
            [
                "name" => __('front.reset_password'),
                "link" => "#"
            ],
        ];
        $page_title = __('front.reset_password') . ' | ' . config('app.name');
        return view("front.auth.reset-password", compact('breadcrumbs', 'page_title'));
    }

    public function showPasswordResetConfirm(Request $request)
    {
        // $request->validate(['token' => 'required']);
        $token = $request->token;

        $tokenExist = DB::table('password_reset_tokens')->where('token', $token)->first();

        if (!$tokenExist) {
            abort(404);
        }
        $breadcrumbs = [
            [
                "name" => "",
                "link" => route('front.index')
            ],
            [
                "name" => __('front.reset_password'),
                "link" => "#"
            ],
        ];
        $page_title = __('front.reset_password') . ' | ' . config('app.name');
        return view("front.auth.reset-password", compact("token", 'breadcrumbs', 'page_title'));
    }

    public function sendPasswordReset(Request $request)
    {
        $email = $request->email;
        $find = User::query()->where("email", $email)->firstOrFail();

        $tokenFind = DB::table("password_reset_tokens")->where("email", $email)->first();
        if ($tokenFind) {
            $token = $tokenFind->token;
        } else {
            $token = Str::random(60);
            DB::table("password_reset_tokens")->insert([
                'email' => $email,
                'token' => $token,
                'created_at' => now()
            ]);
        }

        if ($tokenFind && now()->diffInHours($tokenFind->created_at) < 5) {
            return redirect()->back()->with([
                'message' => 'Daha önce sıfırlama maili mailinize gönderilmiştir. Bir kaç saat sonra tekrar deneyebilirsiniz.',
                'message_type' => 'success'
            ]);
        }


        Mail::to($find->email)->send(new ResetPasswordMail($find, $token));
        // $this->log("password reset mail send", $find->id, $find->toArray(), User::class, true);

        return redirect()->back()->with([
            'message' => 'Parola sıfırlama maili gönderilmiştir.',
            'message_type' => 'success'
        ]);
    }

    public function passwordReset(PasswordResetRequest $request)
    {
        $tokenQuery = DB::table("password_reset_tokens")->where('token', $request->token);
        $tokenExist = $tokenQuery->first();
        if (!$tokenExist)
            abort(404);

        // $userExist = DB::table("users")->where('email', $tokenExist->email);
        $userExist = User::query()->where('email', $tokenExist->email)->first();
        if (!$userExist)
            abort(400, 'Lütfen yöneticiyle iletişime geçin');

        // bcrypt($request->password)
        $userExist->update(['password' => Hash::make($request->password)]);

        $tokenQuery->delete();


        return redirect()->route('front.login')->with([
            'message' => 'Parolanız başarıyla sıfırlanmıştır. Giriş Yapabilirsiniz.',
            'message_type' => 'success'
        ]);;
    }
}
