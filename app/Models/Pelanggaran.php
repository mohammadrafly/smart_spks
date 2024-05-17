<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    use HasFactory;

    protected $table = 'pelanggaran';
    protected $guarded = [];

    public function kriteriaPelanggaran()
    {
        return $this->belongsTo(KriteriaPelanggaran::class, 'id_kriteria', 'id');
    }

    public function jenisPelanggaran()
    {
        return $this->belongsTo(JenisPelanggaran::class, 'id_jenis', 'id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id');
    }

    public function tindakan()
    {
        return $this->belongsTo(Tindakan::class, 'id_tindakan', 'id');
    }

    public function sanksi()
    {
        return $this->belongsTo(Sanksi::class, 'id_sanksi', 'id');
    }
}
