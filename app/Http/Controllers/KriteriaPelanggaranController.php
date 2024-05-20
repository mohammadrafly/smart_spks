<?php

namespace App\Http\Controllers;

use App\Models\KriteriaPelanggaran;
use Illuminate\Http\Request;

class KriteriaPelanggaranController extends Controller
{
    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {
            $request->validate([
                'kriteria' => 'required|string|max:255',
                'bobot' => 'required|numeric|min:0|max:100',
            ]);

            $currentTotalBobot = KriteriaPelanggaran::sum('bobot');
            $newBobot = $request->input('bobot');

            if ($currentTotalBobot + $newBobot > 100) {
                return redirect()->back()->withInput()->withErrors(['error' => 'Total persentasi bobot tidak boleh melebihi 100%.']);
            }

            $latestCode = KriteriaPelanggaran::max('kode');
            $lastNumber = intval(substr($latestCode, 1));

            $nextCode = 'C' . ($lastNumber + 1);

            $data = $request->only(['kriteria', 'bobot']);
            $data['kode'] = $nextCode;

            if (!KriteriaPelanggaran::create($data)) {
                return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menambah kriteria pelanggaran']);
            }

            return redirect()->route('jenispelanggaran')->with('success', 'Berhasil menambah kriteria pelanggaran');
        }

        $currentTotalBobot = KriteriaPelanggaran::sum('bobot');
        $remainingBobot = 100 - $currentTotalBobot;

        return view('pages.dashboard.kriteriapelanggaran.create', [
            'title' => 'Tambah Kriteria Pelanggaran',
            'kriteria' => KriteriaPelanggaran::all(),
            'remainingBobot' => $remainingBobot,
        ]);
    }

    public function update(Request $request, $id)
    {
        $kriteriapelanggaran = KriteriaPelanggaran::find($id);

        if ($request->isMethod('POST')) {
            $request->validate([
                'kriteria' => 'required|string|max:255',
                'bobot' => 'required|string|max:255',
            ]);

            $data = $request->only(['kriteria', 'bobot']);

            if (!$kriteriapelanggaran->update($data)) {
                return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menambah kriteria pelanggaran']);
            }

            return redirect()->route('jenispelanggaran')->with(['success' => 'Berhasil update kriteriapelanggaran!']);
        }

        return view('pages.dashboard.kriteriapelanggaran.update', [
            'title' => 'Perbarui Kriteria Pelanggaran',
            'data' => $kriteriapelanggaran,
        ]);
    }

    public function delete($id)
    {
        $data = KriteriaPelanggaran::findOrFail($id);
        if (!$data->delete()) {
            return redirect()->route('jenispelanggaran')->with(['success' => 'Berhasil hapus kriteria pelanggaran!']);
        }

        return redirect()->route('jenispelanggaran')->with(['success' => 'Berhasil hapus kriteria pelanggaran!']);
    }
}
