<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {   
        return view('pages.dashboard.user.index', [
            'title' => 'Data Pengguna',
            'data' => User::all(),
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'usertype' => $request->usertype,
                'password' => Hash::make($request->password),
            ];

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|numeric|unique:users,phone',
                'usertype' => 'required|string|in:admin,guru,bk',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if (!User::create($data)) {
                return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menambah pengguna']);
            }

            return redirect()->route('user')->with('success', 'Berhasil menambah pengguna');
        }

        return view('pages.dashboard.user.create', [
            'title' => 'Tambah Pengguna',
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if ($request->isMethod('POST')) {
            $data = $request->only(['name', 'email', 'phone', 'usertype']);

            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => 'required|numeric|unique:users,phone,' . $user->id,
                'usertype' => 'required|string|in:admin,guru,bk',
            ];

            $request->validate($rules);

            if (!$user->update($data)) {
                return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menambah pengguna']);
            }

            return redirect()->to('dashboard/user/update/' . $id)->with(['success' => 'Berhasil update pengguna!']);
        }

        return view('pages.dashboard.user.update', [
            'title' => 'Perbarui Pengguna',
            'data' => $user,
        ]);
    }

    public function delete($id)
    {
        $data = User::findOrFail($id);
        if (!$data->delete()) {
            return response()->json(['error' => 'Gagal hapus pengguna!'], 200);
        }

        return redirect()->to('dashboard/user')->with(['success' => 'Berhasil hapus pengguna!']);
    }
}
