<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $page_title = "Profilim";
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->limit('5')->get();
        return view('front.profile', compact('user', 'page_title', 'orders'));
    }

    public function orders()
    {
        $page_title = "Siparişlerim";
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->paginate(10);
        return view('front.profile-orders', compact('user', 'page_title', 'orders'));
    }

    public function order_detail(Request $request, $locale, Order $order)
    {
        $page_title = $order->order_no . "'lu Sipariş Detayları";
        $user = Auth::user();
        // $order_details = $order->details;
        $order_details = $order->details()->with('product')->get();
        return view('front.profile-order-details', compact('user', 'page_title', 'order', 'order_details'));
    }

    public function settings(Request $request)
    {
        $page_title = "Ayarlar";
        $user = Auth::user();
        return view('front.profile-settings', compact('user', 'page_title'));
    }
    public function settingsUpdate(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }
        try {
            $validated = $request->validate([
                'email' => ['email'],
            ]);
            if ($validated) {
                $data = $request->only(['email']);
                $user = Auth::user();
                User::query()->where("id", $user->id)->update($data);
            }

            if (request()->ajax()) {
                return [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Bilgileriniz Başarıyla Güncellendi',
                    'redirect' => to_route("front.profile.settings")->getTargetUrl()
                ];
            }
        } catch (\Throwable $th) {
            if (request()->ajax()) {
                // dd($th->getMessage());
                return [
                    'status' => 'error',
                    'title' => 'Hata!!!',
                    'message' => 'Sistemde bir hata oluştu !.',
                    'redirect' => ''
                ];
            }
        }
    }
    public function passwordUpdate(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }
        $validated = $request->validate([
            "password" => ['required'],
            "npassword" => ["required", Password::min(8)->symbols()->mixedCase()->letters()->numbers()],
            "npasswordr" => ["required", "same:npassword"]
        ], [], ['password' => 'Parola', 'npassword' => 'Yeni Parola', 'npasswordr' => 'Yeni Parola Tekrar']);

        try {
            if ($validated) {
                $data = ['password' => bcrypt($request->npassword)];
                $user = Auth::user();

                if (Hash::check($request->password, $user->password)) {
                    $user->password = bcrypt($request->npassword);
                    $user->save();
                } else {
                    return [
                        'status' => 'error',
                        'title' => 'Hata',
                        'message' => 'Eski Parolanız Yanlış',
                        'redirect' => ''
                    ];
                }
            }

            if (request()->ajax()) {
                return [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Bilgileriniz Başarıyla Güncellendi',
                    'redirect' => to_route("front.profile.settings")->getTargetUrl()
                ];
            }
        } catch (\Throwable $th) {
            if (request()->ajax()) {
                return [
                    'status' => 'error',
                    'title' => 'Hata!!!',
                    'message' => 'Sistemde bir hata oluştu !.',
                    'redirect' => ''
                ];
            }
        }
    }
}
