<?php

namespace App\Http\Controllers;

use App\Models\Sanksi;
use Illuminate\Http\Request;

class SanksiController extends Controller
{
    public function index()
    {   
        return view('pages.dashboard.sanksi.index', [
            'title' => 'Data Sanksi',
            'data' => Sanksi::all(),
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {
            $lastSanksi = Sanksi::latest()->first();
            $lastNumber = $lastSanksi ? intval(substr($lastSanksi->kode_sanksi, 1)) : 0;
            $newNumber = $lastNumber + 1;
            $newKodeSanksi = 'S' . $newNumber;

            $data = [
                'kode_sanksi' => $newKodeSanksi,
                'rentang_point' => $request->rentang_point,
                'jenis_sanksi' => $request->jenis_sanksi,
            ];

            if (!Sanksi::insert($data)) {
                return response()->json(['message' => 'Gagal menambah sanksi'], 200);
            }

            return response()->json(['message' => 'Berhasil menambah sanksi'], 200);
        }

        return view('pages.dashboard.sanksi.create', [
            'title' => 'Tambah sanksi',
        ]);
    }

    public function update(Request $request, $id)
    {
        $sanksi = Sanksi::find($id);
        if ($request->isMethod('POST')) {
            $data = [
                'rentang_point' => $request->rentang_point,
                'jenis_sanksi' => $request->jenis_sanksi,
            ];

            if (!$sanksi->update($data)) {
                return response()->json(['message' => 'Gagal update sanksi'], 200);
            }

            return response()->json(['message' => 'Berhasil update sanksi'], 200);
        }

        return view('pages.dashboard.sanksi.update', [
            'title' => 'Perbarui sanksi',
            'data' => $sanksi,
        ]);
    }

    public function delete($id)
    {
        $data = Sanksi::findOrFail($id);
        if (!$data->delete()) {
            return response()->json(['message' => 'Gagal hapus sanksi!'], 200);
        }

        return response()->json(['message' => 'Berhasil hapus sanksi!'], 200);
    }
}
