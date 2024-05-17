<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {   
        return view('pages.dashboard.siswa.index', [
            'title' => 'Data Siswa',
            'data' => Siswa::all(),
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = [
                'nama' => $request->nama,
                'nis' => $request->nis,
                'kelas' => $request->kelas,
                'wali_kelas' => $request->wali_kelas
            ];

            if (!Siswa::insert($data)) {
                return response()->json(['message' => 'Gagal menambah siswa'], 200);
            }

            return response()->json(['message' => 'Berhasil menambah siswa'], 200);
        }

        return view('pages.dashboard.siswa.create', [
            'title' => 'Tambah siswa',
        ]);
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::find($id);
        if ($request->isMethod('POST')) {
            $data = [
                'nama' => $request->nama,
                'nis' => $request->nis,
                'kelas' => $request->kelas,
                'wali_kelas' => $request->wali_kelas
            ];

            if (!$siswa->update($data)) {
                return response()->json(['message' => 'Gagal update siswa'], 200);
            }

            return response()->json(['message' => 'Berhasil update siswa'], 200);
        }

        return view('pages.dashboard.siswa.update', [
            'title' => 'Perbarui siswa',
            'data' => $siswa,
        ]);
    }

    public function delete($id)
    {
        $data = Siswa::findOrFail($id);
        if (!$data->delete()) {
            return response()->json(['message' => 'Gagal hapus siswa!'], 200);
        }

        return response()->json(['message' => 'Berhasil hapus siswa!'], 200);
    }
}
