<?php

namespace App\Http\Controllers;

use App\Models\Sanksi;
use Illuminate\Http\Request;

class SanksiController extends Controller
{
    /**
     * Generate a unique code with a specified prefix.
     *
     * @param string $prefix
     * @return string
     */
    private function generateUniqueCode($prefix)
    {
        $code = '';
        do {
            $code = $prefix . strtoupper(uniqid());
        } while (Sanksi::where('kode_sanksi', $code)->exists());

        return $code;
    }

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
            $request->validate([
                'rentang_point' => 'required|string|max:255',
                'jenis_sanksi' => 'required|string|max:255',
            ]);

            $data = $request->only(['rentang_point', 'jenis_sanksi']);

            $prefix = 'S';
            $code = $this->generateUniqueCode($prefix);
            
            $data['kode_sanksi'] = $code;

            if (!Sanksi::create($data)) {
                return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menambah sanksi']);
            }

            return redirect()->route('sanksi')->with('success', 'Berhasil menambah sanksi');
        }

        return view('pages.dashboard.sanksi.create', [
            'title' => 'Tambah Sanksi',
        ]);
    }

    public function update(Request $request, $id)
    {
        $sanksi = Sanksi::find($id);

        if ($request->isMethod('POST')) {
            $data = $request->only(['rentang_point', 'jenis_sanksi']);

            $rules = [
                'rentang_point' => 'required|string|max:255',
                'jenis_sanksi' => 'required|string|max:255',
            ];

            $request->validate($rules);

            if (!$sanksi->update($data)) {
                return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menambah sanksi']);
            }

            return redirect()->to('dashboard/sanksi/update/' . $id)->with(['success' => 'Berhasil update sanksi!']);
        }

        return view('pages.dashboard.sanksi.update', [
            'title' => 'Perbarui Sanksi',
            'data' => $sanksi,
        ]);
    }

    public function delete($id)
    {
        $data = Sanksi::findOrFail($id);
        if (!$data->delete()) {
            return response()->json(['error' => 'Gagal hapus sanksi!'], 200);
        }

        return redirect()->to('dashboard/sanksi')->with(['success' => 'Berhasil hapus sanksi!']);
    }
}
