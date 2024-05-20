<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
            // Validate the request data
            $request->validate([
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                'phone' => 'nullable|string|max:15',
            ]);

            $data = $request->only(['name', 'email', 'phone']);

            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('photos', 'public');
                $data['photo'] = $photoPath;

                if ($user->photo) {
                    Storage::disk('public')->delete($user->photo);
                }
            }

            if (!$user->update($data)) {
                return redirect()->back()->withInput()->withErrors(['error' => 'Gagal update profile']);
            }

            return redirect()->to('dashboard/profile')->with(['success' => 'Berhasil update profile!']);
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

            if (!Hash::check($old_password, $user->password)) {
                return response()->json(['message' => 'Password lama salah!'], 200);
            }

            $user->password = Hash::make($new_password);
            $user->save();
    
            return redirect()->route('profile.update')->with('success', 'Berhasil update password');
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
