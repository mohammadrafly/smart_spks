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

            $user = User::where('email', $data['email'])->first();

            if (!empty($user['email'])) {
                return response()->json(['message' => 'Email sudah ada di database!'], 200);
            }

            if (!empty($user['phone'])) {
                return response()->json(['message' => 'Nomor sudah ada di database!'], 200);
            }

            if (!User::insert($data)) {
                return response()->json(['message' => 'Gagal menambah pengguna'], 200);
            }

            return response()->json(['message' => 'Berhasil menambah pengguna', 'redirect' => route('user')], 200);
        }

        return view('pages.dashboard.user.create', [
            'title' => 'Tambah Pengguna',
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if ($request->isMethod('POST')) {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'usertype' => $request->usertype
            ];

            if (!$user->update($data)) {
                return response()->json(['message' => 'Gagal menambah pengguna'], 200);
            }

            return response()->json(['message' => 'Berhasil menambah pengguna'], 200);
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
            return response()->json(['message' => 'Gagal hapus pengguna!'], 200);
        }

        return response()->json(['message' => 'Berhasil hapus pengguna!'], 200);
    }
}
