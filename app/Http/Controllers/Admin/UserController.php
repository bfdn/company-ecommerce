<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Kullanıcı Listele|Kullanıcı Ekle|Kullanıcı Düzenle|Kullanıcı Sil', ['only' => ['index', 'show']]);
        $this->middleware('permission:Kullanıcı Ekle', ['only' => ['create', 'store']]);
        $this->middleware('permission:Kullanıcı Düzenle', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Kullanıcı Sil', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::query()->with('roles')
            ->notIsAdmin(Auth::user())
            ->status($request->status)
            ->searchText($request->q)
            ->date($request->date)
            ->paginate(10);

        $status = StatusEnum::cases();


        return view('admin.users.index', ['items' => $users, 'status' => $status]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();

        return view('admin.users.create-update', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $data = $request->except(['_token', '_method', 'password_re', 'role']);
            $data['password'] = bcrypt($data['password']);
            $data['status'] = isset($data['status']) ? 1 : 0;
            // $data['email_verified_at'] = date("Y-m-d h:i:s");
            $data['email_verified_at'] = now();
            $user = User::create($data);
            $user->assignRole($request->role);
            if (request()->ajax()) {
                // dd(redirect()->route("admin.settings.index")->getTargetUrl());
                return [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Kayıt Başarıyla Eklendi',
                    'redirect' => to_route("admin.user.index")->getTargetUrl()
                ];
            }

            return back()->with('response', [
                'status' => 'success',
                'title' => 'İşlem Başarılı',
                'message' => 'Kayıt Başarıyla Eklendi'
            ]);
        } catch (\Throwable $th) {
            if (request()->ajax()) {
                return [
                    'status' => 'error',
                    'title' => 'Hata!!!',
                    'message' => 'Sistemde bir hata oluştu !.',
                    'redirect' => ''
                ];
            }

            return back()->with('response', [
                'status' => 'error',
                'title' => 'Hata!!!',
                'message' => 'Sistemde bir hata oluştu !.'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $user_role = $user->roles->first();

        return view('admin.users.create-update', ['item' => $user, 'user_role' => $user_role, 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->except(['_token', '_method', 'password_re', 'password', 'role']);
        if (!empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        }

        //$data['status'] = isset($data['status']) ? 1 : 0;
        try {
            $user->update($data, ['id' => $user->id]);
            $user->syncRoles([$request->role]);
            if (request()->ajax()) {
                // dd(redirect()->route("admin.settings.index")->getTargetUrl());
                return [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Kayıt Başarıyla Güncellendi',
                    'redirect' => to_route("admin.user.index")->getTargetUrl()
                ];
            }

            return back()->with('response', [
                'status' => 'success',
                'title' => 'İşlem Başarılı',
                'message' => 'Kayıt Başarıyla Güncellendi'
            ]);
        } catch (\Throwable $th) {
            if (request()->ajax()) {
                // dd($th->getMessage());
                return [
                    'status' => 'error',
                    'title' => 'Hata!!!',
                    'message' => 'Sistemde bir hata oluştu !',
                    'redirect' => ''
                ];
            }

            return back()->with('response', [
                'status' => 'error',
                'title' => 'Hata!!!',
                'message' => 'Sistemde bir hata oluştu !'
            ]);
        }
    }

    public function statusChange(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'status' => ['required'],
            ]);
            if ($validated) {
                $user->status  = ($request->status === "true") ? 1 : 0;
                $user->save();
            }
        } catch (\Throwable $th) {
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            if (request()->ajax()) {
                // dd(redirect()->route("admin.settings.index")->getTargetUrl());
                return [
                    'status' => 'success',
                    'title' => 'İşlem Başarılı',
                    'message' => 'Kayıt Başarıyla Silindi',
                    'redirect' => to_route("admin.user.index")->getTargetUrl()
                ];
            }
        } catch (\Throwable $th) {
            if (request()->ajax()) {
                return [
                    'status' => 'error',
                    'title' => 'Hata!!!',
                    'message' => 'Sistemde bir hata oluştu !',
                    'redirect' => ''
                ];
            }
        }
    }
}
