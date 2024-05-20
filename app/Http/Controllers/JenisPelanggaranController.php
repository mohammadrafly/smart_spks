<?php

namespace App\Http\Controllers;

use App\Models\JenisPelanggaran;
use App\Models\KriteriaPelanggaran;
use Illuminate\Http\Request;

class JenisPelanggaranController extends Controller
{
    public function index()
    {   
        $kriteria = KriteriaPelanggaran::all();
        $totalBobot = $kriteria->sum('bobot');
        return view('pages.dashboard.jenispelanggaran.index', [
            'title' => 'Data Kriteria Pelanggaran',
            'totalBobot' => $totalBobot,
            'jenis' => JenisPelanggaran::with('kriteria')->get(),
            'kriteria' => KriteriaPelanggaran::all(),
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {
            $request->validate([
                'kode_kriteria' => 'required|string|max:255',
                'jenis_pelanggaran' => 'required|string|max:255',
                'point' => 'required|string|max:255',
            ]);

            $data = $request->only(['kode_kriteria', 'jenis_pelanggaran', 'point']);

            if (!JenisPelanggaran::create($data)) {
                return redirect()->back()->withInput()->withErrors('error', 'Gagal menambah jenis pelanggaran');
            }

            return redirect()->route('jenispelanggaran')->with('success', 'Berhasil menambah jenis pelanggaran');
        }

        return view('pages.dashboard.jenispelanggaran.create', [
            'title' => 'Tambah Jenis Pelanggaran',
            'kriteria' => KriteriaPelanggaran::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $jenispelanggaran = JenisPelanggaran::find($id);

        if ($request->isMethod('POST')) {
            $data = $request->only(['kode_kriteria', 'jenis_pelanggaran', 'point']);

            $request->validate([
                'kode_kriteria' => 'required|string|max:255',
                'jenis_pelanggaran' => 'required|string|max:255',
                'point' => 'required|string|max:255',
            ]);

            if (!$jenispelanggaran->update($data)) {
                return redirect()->back()->withInput()->withErrors('error', 'Gagal menambah jenis pelanggaran');
            }

            return redirect()->route('jenispelanggaran')->with('success', 'Berhasil update jenis pelanggaran!');
        }

        return view('pages.dashboard.jenispelanggaran.update', [
            'title' => 'Perbarui Jenis Pelanggaran',
            'data' => $jenispelanggaran,
            'kriteria' => KriteriaPelanggaran::all(),
        ]);
    }

    public function delete($id)
    {
        $data = JenisPelanggaran::findOrFail($id);
        if (!$data->delete()) {
            return redirect()->route('jenispelanggaran')->with('error', 'Gagal hapus jenis pelanggaran!');
        }

        return redirect()->route('jenispelanggaran')->with('success', 'Berhasil hapus jenis pelanggaran!');
    }
}
