<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    use HasFactory;

    protected $table = 'pelanggaran';
    protected $guarded = [];

    public function listPelanggaran()
    {
        return $this->hasMany(ListPelanggaran::class)->with('kriteria', 'jenis');
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
