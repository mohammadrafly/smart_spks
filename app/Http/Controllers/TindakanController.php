<?php

namespace App\Http\Controllers;

use App\Models\Tindakan;
use Illuminate\Http\Request;

class TindakanController extends Controller
{
    /**
     * Generate a unique code with a specified prefix.
     *
     * @param string $prefix
     * @return string
     */
    private function generateUniqueCode($prefix)
    {
        $latestCode = Tindakan::where('kode_tindakan', 'like', $prefix . '%')
                             ->orderBy('kode_tindakan', 'desc')
                             ->first();

        $counter = $latestCode ? intval(substr($latestCode->kode_tindakan, strlen($prefix))) + 1 : 1;
 
        $code = $prefix . str_pad($counter, STR_PAD_LEFT);
    
        return $code;
    }
    

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
            $request->validate([
                'rentang_point' => 'required|string|max:255',
                'tindakan_sekolah' => 'required|string|max:255',
            ]);

            $data = $request->only(['rentang_point', 'tindakan_sekolah']);

            $prefix = 'T';
            $code = $this->generateUniqueCode($prefix);

            $data = $request->only(['rentang_point', 'tindakan_sekolah']);
            $data['kode_tindakan'] = $code;

            if (!Tindakan::create($data)) {
                return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menambah tindakan']);
            }

            return redirect()->route('tindakan')->with('success', 'Berhasil menambah tindakan');
        }

        return view('pages.dashboard.tindakan.create', [
            'title' => 'Tambah Tindakan',
        ]);
    }

    public function update(Request $request, $id)
    {
        $tindakan = Tindakan::find($id);

        if ($request->isMethod('POST')) {
            $data = $request->only(['rentang_point', 'tindakan_sekolah']);

            $rules = [
                'rentang_point' => 'required|string|max:255',
                'tindakan_sekolah' => 'required|string|max:255',
            ];

            $request->validate($rules);

            if (!$tindakan->update($data)) {
                return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menambah tindakan']);
            }

            return redirect()->route('tindakan')->with(['success' => 'Berhasil update tindakan!']);
        }

        return view('pages.dashboard.tindakan.update', [
            'title' => 'Perbarui Tindakan',
            'data' => $tindakan,
        ]);
    }

    public function delete($id)
    {
        $data = Tindakan::findOrFail($id);
        if (!$data->delete()) {
            return redirect()->route('tindakan')->with(['error' => 'Gagal hapus tindakan!']);
        }

        return redirect()->route('tindakan')->with(['success' => 'Berhasil hapus tindakan!']);
    }
}
