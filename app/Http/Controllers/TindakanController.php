<?php

namespace App\Http\Controllers;

use App\Models\Tindakan;
use Illuminate\Http\Request;

class TindakanController extends Controller
{
    public function index()
    {   
        return view('pages.dashboard.tindakan.index', [
            'title' => 'Data Tindakan',
            'data' => Tindakan::all(),
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {
            $lastTindakan = Tindakan::latest()->first();
            $lastNumber = $lastTindakan ? intval(substr($lastTindakan->kode_tindakan, 1)) : 0;
            $newNumber = $lastNumber + 1;
            $newKodeTindakan = 'T' . $newNumber;
    
            $data = [
                'kode_tindakan' => $newKodeTindakan,
                'kode_tindakan' => $request->kode_tindakan,
                'rentang_point' => $request->rentang_point,
                'tindakan_sekolah' => $request->tindakan_sekolah
            ];

            if (!Tindakan::insert($data)) {
                return response()->json(['message' => 'Gagal menambah tindakan'], 200);
            }

            return response()->json(['message' => 'Berhasil menambah tindakan'], 200);
        }

        return view('pages.dashboard.tindakan.create', [
            'title' => 'Tambah tindakan',
        ]);
    }

    public function update(Request $request, $id)
    {
        $tindakan = Tindakan::find($id);
        if ($request->isMethod('POST')) {
            $data = [
                'rentang_point' => $request->rentang_point,
                'tindakan_sekolah' => $request->tindakan_sekolah
            ];

            if (!$tindakan->update($data)) {
                return response()->json(['message' => 'Gagal update tindakan'], 200);
            }

            return response()->json(['message' => 'Berhasil update tindakan'], 200);
        }

        return view('pages.dashboard.tindakan.update', [
            'title' => 'Perbarui tindakan',
            'data' => $tindakan,
        ]);
    }

    public function delete($id)
    {
        $data = Tindakan::findOrFail($id);
        if (!$data->delete()) {
            return response()->json(['message' => 'Gagal hapus tindakan!'], 200);
        }

        return response()->json(['message' => 'Berhasil hapus tindakan!'], 200);
    }
}
