<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListPelanggaran extends Model
{
    use HasFactory;

    protected $table = 'list_pelanggaran';
    protected $guarded = [];

    public function kriteria()
    {
        return $this->belongsTo(KriteriaPelanggaran::class, 'id_kriteria', 'id');
    }

    public function jenis()
    {
        return $this->belongsTo(JenisPelanggaran::class, 'id_jenis', 'id');
    }
}
