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
        Schema::table('user_cbt_susulan', function (Blueprint $table) {
            // Hapus kolom lama
            $table->dropColumn(['username', 'password', 'firstname', 'lastname', 'email', 'department']);
    
            // Tambah kolom baru
            $table->uuid('id_kartu_ujian');
            $table->uuid('id_siswa');  // Pastikan tipe data ini sesuai dengan kolom id di tabel siswa Anda
    
            // Set foreign key constraint
            $table->foreign('id_kartu_ujian')->references('id')->on('kartu_ujian');
            $table->foreign('id_siswa')->references('id')->on('siswa'); // asumsikan tabel siswa adalah 'siswa'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_cbt_susulan', function (Blueprint $table) {
            // Kembalikan kolom lama jika perlu
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->nullable();
            $table->string('department')->nullable();
    
            // Hapus kolom baru
            $table->dropForeign(['id_kartu_ujian']);
            $table->dropForeign(['id_siswa']);
            $table->dropColumn(['id_kartu_ujian', 'id_siswa']);
        });
    }
};
