<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('POST')) {
            $credentials = $request->only('email', 'password');

            $user = User::where('email', $credentials['email'])->first();

            if (!$user) {
                return response()->json(['message' => 'Email tidak ada di database!'], 409);
            }

            if (!Hash::check($credentials['password'], $user->password)) {
                return response()->json(['message' => 'Password salah!'], 409);
            }        

            if (Auth::attempt($credentials)) {
                return response()->json(['message' => 'Berhasil Login!', 'redirect' => route('dashboard')], 201);
            } 

            if (!Auth::attempt($credentials)) {
                return response()->json(['message' => 'Gagal Login!'], 409);
            }
        }

        return view('pages.auth.login', [
            'title' => 'Login Page'
        ]);
    }

    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->only(['name', 'email', 'password', 'phone']);
            $data['password'] = Hash::make($data['password']);

            $user = User::where('email', $data['email'])->first();

            if ($user) {
                return response()->json(['message' => 'Email sudah ada di database!'], 409);
            }

            User::create($data);
            return response()->json(['message' => 'Berhasil daftar!', 'redirect' => route('login')], 201);
        }

        return view('pages.auth.register', [
            'title' => 'Register Page'
        ]);
    }
}
