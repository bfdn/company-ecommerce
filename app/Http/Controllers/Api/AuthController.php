<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $requestData = $request->all();

        // $this->validate($request, [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|unique:users',
        //     'password' => 'required|string|min:6'
        // ], [], [
        //     'name' => 'Ad Soyad',
        //     'email' => 'Email',
        //     'password' => 'Parola'
        // ]);

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6'
        ]);

        $data = User::create([
            'name' => $requestData['name'],
            'email' => $requestData['email'],
            'password' => Hash::make($requestData['password']),
        ]);

        return apiResponse(__('Kayıt Başarıyla Oluşturuldu'), 200, $data);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        // $this->validate($request, [
        //     'email' => 'required|string|email',
        //     'password' => 'required|string'
        // ], [], [
        //     'email' => 'Email',
        //     'password' => 'Parola'
        // ]);


        if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        // if(auth()->attempt(['email'=>$request->email,'password'=>$request->password]))
        {
            $user = Auth::user();
            $token = $user->createToken('api_case')->accessToken;
            return apiResponse(__('Success Login'), 200, ['token' => $token, 'user' => $user]);
        }

        return apiResponse(__('UNAUTHORIZED'), 401);
    }
}
