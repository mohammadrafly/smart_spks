<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {   
        return view('pages.dashboard.siswa.index', [
            'title' => 'Data Siswa',
            'data' => Siswa::with('walikelas')->get(),
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = $request->only(['nama', 'nis', 'kelas', 'wali_kelas_id']);

            $request->validate([
                'nama' => 'required|string|max:255',
                'nis' => 'required|numeric|unique:siswa,nis',
                'kelas' => 'required|string|max:255',
                'wali_kelas_id' => 'required|numeric',
            ]);

            if (!Siswa::create($data)) {
                return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menambah siswa']);
            }

            return redirect()->route('siswa')->with('success', 'Berhasil menambah siswa');
        }

        return view('pages.dashboard.siswa.create', [
            'title' => 'Tambah Siswa',
            'wali' => User::where('usertype', 'bk/guru')->get()
        ]);
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::with('walikelas')->find($id);

        if ($request->isMethod('POST')) {
            $data = $request->only(['nama', 'nis', 'kelas', 'wali_kelas']);

            $rules = [
                'nama' => 'required|string|max:255',
                'nis' => 'required|numeric|unique:siswa,nis,' . $siswa->id,
                'kelas' => 'required|string|max:255',
                'wali_kelas_id' => 'required|numeric',
            ];

            $request->validate($rules);

            if (!$siswa->update($data)) {
                return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menambah siswa']);
            }

            return redirect()->route('siswa')->with(['success' => 'Berhasil update siswa!']);
        }

        return view('pages.dashboard.siswa.update', [
            'title' => 'Perbarui Siswa',
            'data' => $siswa,
            'wali' => User::where('usertype', 'bk/guru')->get()
        ]);
    }

    public function delete($id)
    {
        $data = Siswa::findOrFail($id);
        if (!$data->delete()) {
            return redirect()->route('siswa')->with(['error' => 'Gagal hapus siswa!']);
        }

        return redirect()->route('siswa')->with(['success' => 'Berhasil hapus siswa!']);
    }
}
