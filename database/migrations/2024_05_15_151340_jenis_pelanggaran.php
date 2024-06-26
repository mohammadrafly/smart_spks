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
        Schema::create('kriteria_pelanggaran', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('kriteria');
            $table->string('bobot');
            $table->timestamps();
        });

        Schema::create('jenis_pelanggaran', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kriteria');
            $table->string('jenis_pelanggaran');
            $table->string('point');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriteria_pelanggaran');
        Schema::dropIfExists('jenis_pelanggaran');
    }
};
