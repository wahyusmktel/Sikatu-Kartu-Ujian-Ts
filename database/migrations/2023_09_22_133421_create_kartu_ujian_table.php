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
        Schema::create('kartu_ujian', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID untuk kolom id
            $table->foreignUuid('id_ujian')->references('id')->on('data_ujian')->onDelete('cascade'); // Mengambil data dari kolom id pada tabel data_ujian
            $table->foreignUuid('id_siswa')->references('id')->on('siswa')->onDelete('cascade'); // Menambahkan kolom id_siswa yang mengambil referensi dari tabel siswa
            $table->string('username_ujian');
            $table->string('password_ujian');
            $table->boolean('status')->default(false); // Status dengan nilai default false
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kartu_ujian');
    }
};
