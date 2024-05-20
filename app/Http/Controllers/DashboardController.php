<?php

namespace App\Http\Controllers;

use App\Models\KriteriaPelanggaran;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $data = Pelanggaran::all();

        $groupedData = $data->groupBy('tingkat')->map(function ($group) {
            return $group->count();
        });
    
        $formattedData = $groupedData->map(function ($value, $key) {
            return ['label' => $key, 'value' => $value];
        })->values();
    

        return view('pages.dashboard.index', [
            'title' => 'Dashboard',
            'data' => $formattedData,
            'countPelanggar' => Pelanggaran::distinct('id_siswa')->count('id_siswa'),
            'countSiswa' => Siswa::count(),
            'countSubKriteria' => KriteriaPelanggaran::count(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if ($request->isMethod('POST')) {
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
                return redirect()->back()->withInput()->withErrors('error', 'Gagal update profile');
            }

            return redirect()->to('dashboard/profile')->with('success', 'Berhasil update profile!');
        }

        return view('pages.dashboard.profile', [
            'title' => 'Update Profile',
            'data' => User::find(Auth::user()->id),
        ]);
    }

    public function updatePassword(Request $request)
    {
        if ($request->isMethod('POST')) {
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|confirmed',
            ]);
    
            $user = User::find(Auth::id());
            $old_password = $request->old_password;
            $new_password = $request->new_password;
    
            if (!Hash::check($old_password, $user->password)) {
                return redirect()->route('profile.update')->with('error', 'Gagal update password: Password lama salah.');
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
