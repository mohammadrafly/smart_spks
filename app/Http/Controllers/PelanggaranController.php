<?php

namespace App\Http\Controllers;

use App\Models\JenisPelanggaran;
use App\Models\KriteriaPelanggaran;
use App\Models\ListPelanggaran;
use App\Models\Pelanggaran;
use App\Models\Sanksi;
use App\Models\Siswa;
use App\Models\Tindakan;
use Illuminate\Http\Request;

class PelanggaranController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.pelanggaran.index', [
            'title' => 'Pelanggaran Siswa',
            'data' => Pelanggaran::with('listPelanggaran', 'siswa', 'tindakan', 'sanksi')->get(),
        ]);
    }

    function parseRange($range)
    {
        $parts = explode('-', $range);
        if (count($parts) === 2) {
            return [
                'min' => (float) trim($parts[0]),
                'max' => (float) trim($parts[1]),
            ];
        }
        return null;
    }

    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {
            $request->validate([
                'id_siswa' => 'required|string|max:255',
                'id_kriteria' => 'required|array',
                'id_kriteria.*' => 'exists:kriteria_pelanggaran,id',
                'id_jenis' => 'required|array',
                'id_jenis.*' => 'exists:jenis_pelanggaran,id',
            ]);
        
            try {
                $idSiswa = $request->input('id_siswa');
                $idKriteria = $request->input('id_kriteria');
                $idJenis = $request->input('id_jenis');
        
                $normalisasi = [];
                foreach ($idKriteria as $kriteriaId) {
                    $kriteria = KriteriaPelanggaran::findOrFail($kriteriaId);
                    $normalisasi[$kriteria->kode][] = $kriteria->bobot / 100; 
                }
        
                
                $utility = [];
                foreach ($idJenis as $jenisId) {
                    $jenis = JenisPelanggaran::findOrFail($jenisId);
                    $utility[$jenis->kode_kriteria][] = intval($jenis->point);
                }                
        
                $result = [];
                foreach ($normalisasi as $kode => $values1) {
                    if (isset($utility[$kode])) {
                        $values2 = $utility[$kode];
                        
                        if (count($values1) === count($values2)) {
                            $result[$kode] = [];
                            for ($i = 0; $i < count($values1); $i++) {
                                $result[$kode][] = $values1[$i] * $values2[$i];
                            }
                        } else {
                            $result[$kode] = null;
                        }
                    }
                }

                $summedResults = [];
                foreach ($result as $kode => $values) {
                    if (is_array($values)) {
                        $summedResults[$kode] = array_sum($values);
                    } else {
                        $summedResults[$kode] = null; 
                    }
                }

                $overallScore = array_sum($summedResults);
        
                $tindakan = Tindakan::all()->first(function ($tindakan) use ($overallScore) {
                    $range = $this->parseRange($tindakan->rentang_point);
                    return $range && $overallScore >= $range['min'] && $overallScore <= $range['max'];
                });
        
                $sanksi = Sanksi::all()->first(function ($sanksi) use ($overallScore) {
                    $range = $this->parseRange($sanksi->rentang_point);
                    return $range && $overallScore >= $range['min'] && $overallScore <= $range['max'];
                });

                $pelanggaran = Pelanggaran::create([
                    'id_siswa' => $idSiswa,
                    'id_tindakan' => $tindakan->id, 
                    'id_sanksi' => $sanksi->id, 
                ]);

                foreach ($idKriteria as $index => $idKriteriaItem) {
                    ListPelanggaran::create([
                        'pelanggaran_id' => $pelanggaran->id,
                        'id_kriteria' => $idKriteriaItem,
                        'id_jenis' => $idJenis[$index], 
                    ]);
                }
        
                return redirect()->route('pelanggaran')->with('success', 'Berhasil menambah pelanggaran');
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menambah pelanggaran']);
            }
        }        

        return view('pages.dashboard.pelanggaran.create', [
            'title' => 'Tambah Pelanggaran',
            'siswa' => Siswa::all(),
            'kriteria_pelanggaran' => KriteriaPelanggaran::with('jenis')->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('POST')) {
            $request->validate([
                'id_siswa' => 'required|string|max:255',
                'id_kriteria' => 'required|array',
                'id_kriteria.*' => 'exists:kriteria_pelanggaran,id',
                'id_jenis' => 'required|array',
                'id_jenis.*' => 'exists:jenis_pelanggaran,id',
            ]);
    
            try {
                $idSiswa = $request->input('id_siswa');
                $idKriteria = $request->input('id_kriteria');
                $idJenis = $request->input('id_jenis');
    
                $normalisasi = [];
                foreach ($idKriteria as $kriteriaId) {
                    $kriteria = KriteriaPelanggaran::findOrFail($kriteriaId);
                    $normalisasi[$kriteria->kode][] = $kriteria->bobot / 100; 
                }
        
                
                $utility = [];
                foreach ($idJenis as $jenisId) {
                    $jenis = JenisPelanggaran::findOrFail($jenisId);
                    $utility[$jenis->kode_kriteria][] = intval($jenis->point);
                }                
        
                $result = [];
                foreach ($normalisasi as $kode => $values1) {
                    if (isset($utility[$kode])) {
                        $values2 = $utility[$kode];
                        
                        if (count($values1) === count($values2)) {
                            $result[$kode] = [];
                            for ($i = 0; $i < count($values1); $i++) {
                                $result[$kode][] = $values1[$i] * $values2[$i];
                            }
                        } else {
                            $result[$kode] = null;
                        }
                    }
                }

                $summedResults = [];
                foreach ($result as $kode => $values) {
                    if (is_array($values)) {
                        $summedResults[$kode] = array_sum($values);
                    } else {
                        $summedResults[$kode] = null; 
                    }
                }

                $overallScore = array_sum($summedResults);
    
                $tindakan = Tindakan::all()->first(function ($tindakan) use ($overallScore) {
                    $range = $this->parseRange($tindakan->rentang_point);
                    return $range && $overallScore >= $range['min'] && $overallScore <= $range['max'];
                });
    
                $sanksi = Sanksi::all()->first(function ($sanksi) use ($overallScore) {
                    $range = $this->parseRange($sanksi->rentang_point);
                    return $range && $overallScore >= $range['min'] && $overallScore <= $range['max'];
                });
    
                $pelanggaran = Pelanggaran::findOrFail($id);
                $pelanggaran->update([
                    'id_siswa' => $idSiswa,
                    'id_tindakan' => $tindakan->id,
                    'id_sanksi' => $sanksi->id,
                ]);
    
                $pelanggaran->listPelanggaran()->delete();
    
                foreach ($idKriteria as $index => $idKriteriaItem) {
                    ListPelanggaran::create([
                        'pelanggaran_id' => $pelanggaran->id,
                        'id_kriteria' => $idKriteriaItem,
                        'id_jenis' => $idJenis[$index],
                    ]);
                }
    
                return redirect()->route('pelanggaran')->with('success', 'Berhasil memperbarui pelanggaran');
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->withErrors(['error' => 'Gagal memperbarui pelanggaran']);
            }
        }
    
        return view('pages.dashboard.pelanggaran.update', [
            'title' => 'Edit Pelanggaran',
            'siswa' => Siswa::all(),
            'kriteria_pelanggaran' => KriteriaPelanggaran::with('jenis')->get(),
            'pelanggaran' => Pelanggaran::findOrFail($id), 
        ]);
    }    

    public function detail($id)
    {
        
    }

    public function delete($id)
    {
        $data = Pelanggaran::findOrFail($id);
        if (!$data->delete()) {
            return redirect()->route('pelanggaran')->with(['error' => 'Gagal hapus pelanggaran!']);
        }

        return redirect()->route('pelanggaran')->with(['success' => 'Berhasil hapus pelanggaran!']);
    }
}
