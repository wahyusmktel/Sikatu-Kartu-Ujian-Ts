<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('aktivasi_kartu', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_kartu')->constrained('kartu_ujian')->cascadeOnDelete();
            $table->foreignUuid('id_ujian')->constrained('data_ujian')->cascadeOnDelete();
            $table->foreignUuid('id_siswa')->constrained('siswa')->cascadeOnDelete();
            $table->boolean('status_aktivasi')->default(true);
            $table->dateTime('tgl_download_kartu')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktivasi_kartu');
    }
};
