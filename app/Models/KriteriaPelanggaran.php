<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaPelanggaran extends Model
{
    use HasFactory;

    protected $table = 'kriteria_pelanggaran';
    protected $guarded = [];

    public function jenis()
    {
        return $this->hasMany(JenisPelanggaran::class, 'kode_kriteria', 'kode');
    }
}
