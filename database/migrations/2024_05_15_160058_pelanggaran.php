<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pelanggaran', function (Blueprint $table) {
            $table->id();
            $table->string('id_siswa');
            $table->string('id_tindakan');
            $table->string('id_sanksi');
            $table->enum('tingkat', ['Pelanggaran Ringan', 'Pelanggaran Sedang', 'Tindak Pidana Ringan (TIPIRING)', 'Tindak Pidana Berat (TIPIRAT)']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggaran');
    }
};
