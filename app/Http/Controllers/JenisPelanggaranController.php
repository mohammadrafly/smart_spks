<?php

namespace App\Http\Controllers;

use App\Models\JenisPelanggaran;
use Illuminate\Http\Request;

class JenisPelanggaranController extends Controller
{
    public function index()
    {   
        return view('pages.dashboard.jenispelanggaran.index', [
            'title' => 'Data Jenispelanggaran',
            'data' => JenisPelanggaran::all(),
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = [
                'kode_kriteria' => $request->kode_kriteria,
                'jenis_pelanggaran' => $request->jenis_pelanggaran,
                'point' => $request->point,
            ];

            if (!JenisPelanggaran::insert($data)) {
                return response()->json(['message' => 'Gagal menambah jenis pelanggaran'], 200);
            }

            return response()->json(['message' => 'Berhasil menambah jenis pelanggaran'], 200);
        }

        return view('pages.dashboard.jenispelanggaran.create', [
            'title' => 'Tambah jenis pelanggaran',
        ]);
    }

    public function update(Request $request, $id)
    {
        $jenispelanggaran = JenisPelanggaran::find($id);
        if ($request->isMethod('POST')) {
            $data = [
                'kode_kriteria' => $request->kode_kriteria,
                'jenis_pelanggaran' => $request->jenis_pelanggaran,
                'point' => $request->point,
            ];

            if (!$jenispelanggaran->update($data)) {
                return response()->json(['message' => 'Gagal update jenis pelanggaran'], 200);
            }

            return response()->json(['message' => 'Berhasil update jenis pelanggaran'], 200);
        }

        return view('pages.dashboard.jenispelanggaran.update', [
            'title' => 'Perbarui jenis pelanggaran',
            'data' => $jenispelanggaran,
        ]);
    }

    public function delete($id)
    {
        $data = JenisPelanggaran::findOrFail($id);
        if (!$data->delete()) {
            return response()->json(['message' => 'Gagal hapus jenis pelanggaran!'], 200);
        }

        return response()->json(['message' => 'Berhasil hapus jenis pelanggaran!'], 200);
    }
}
