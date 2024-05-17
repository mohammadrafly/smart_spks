<?php

namespace App\Http\Controllers;

use App\Models\KriteriaPelanggaran;
use Illuminate\Http\Request;

class KriteriaPelanggaranController extends Controller
{
    public function index()
    {   
        return view('pages.dashboard.kriteriapelanggaran.index', [
            'title' => 'Data Kriteriapelanggaran',
            'data' => KriteriaPelanggaran::all(),
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = [
                'kode_kriteria' => $request->kode_kriteria,
                'kriteria' => $request->kriteria,
            ];

            if (!KriteriaPelanggaran::insert($data)) {
                return response()->json(['message' => 'Gagal menambah kriteria pelanggaran'], 200);
            }

            return response()->json(['message' => 'Berhasil menambah kriteria pelanggaran'], 200);
        }

        return view('pages.dashboard.kriteriapelanggaran.create', [
            'title' => 'Tambah kriteria pelanggaran',
        ]);
    }

    public function update(Request $request, $id)
    {
        $kriteriapelanggaran = KriteriaPelanggaran::find($id);
        if ($request->isMethod('POST')) {
            $data = [
                'kode_kriteria' => $request->kode_kriteria,
                'kriteria' => $request->kriteria,
            ];

            if (!$kriteriapelanggaran->update($data)) {
                return response()->json(['message' => 'Gagal update kriteria pelanggaran'], 200);
            }

            return response()->json(['message' => 'Berhasil update kriteria pelanggaran'], 200);
        }

        return view('pages.dashboard.kriteriapelanggaran.update', [
            'title' => 'Perbarui kriteria pelanggaran',
            'data' => $kriteriapelanggaran,
        ]);
    }

    public function delete($id)
    {
        $data = KriteriaPelanggaran::findOrFail($id);
        if (!$data->delete()) {
            return response()->json(['message' => 'Gagal hapus kriteria pelanggaran!'], 200);
        }

        return response()->json(['message' => 'Berhasil hapus kriteria pelanggaran!'], 200);
    }
}
