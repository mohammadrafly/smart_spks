<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPelanggaran extends Model
{
    use HasFactory;

    protected $table = 'jenis_pelanggaran';
    protected $guarded = [];

    public function kriteria()
    {
        return $this->belongsTo(KriteriaPelanggaran::class, 'kode_kriteria', 'kode');
    }
}
