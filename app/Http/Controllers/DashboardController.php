<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.index',[
            'title' => 'Dashboard',
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if ($request->isMethod('POST')) {
            $data = [
                'photo' => $request->photo,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ];

            $user->update($data);
            return response()->json(['message' => 'Berhasil update profile!'], 200);
        }

        return view('pages.dashboard.profile', [
            'title' => 'Update Profile',
            'data' => User::find(Auth::user()->id),
        ]);
    }

    public function updatePassword(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if ($request->isMethod('POST')) {
            $old_password = $request->old_password;
            $new_password = $request->new_password;

            if (!Hash::check($user['password'], $old_password)) {
                return response()->json(['message' => 'Password lama salah!'], 200);
            }

            $user->update(['password' => Hash::make($new_password)]);
            return response()->json(['message' => 'Berhasil update profile!'], 200);
        }
    }

    public function logout()
    {
        Auth::logout();

        return response()->json([
            'message' => 'Berhasil Logout!', 
            'code' => 201, 
            'redirect' => route('login')
        ]);
    }
}
