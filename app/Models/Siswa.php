<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    
    protected $table = 'siswa';
    protected $guarded = [];

    public function walikelas()
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }
}
