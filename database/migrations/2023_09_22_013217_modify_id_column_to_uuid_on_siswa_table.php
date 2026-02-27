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
        Schema::table('siswa', function (Blueprint $table) {
            // 1. Hapus primary key yang ada
            $table->dropPrimary('siswa_id_primary');  // Nama constraint ini mungkin berbeda, Anda harus memeriksa skema database Anda.

            // 2. Ubah tipe kolom id menjadi UUID
            $table->uuid('id')->change();

            // 3. Tambahkan kembali primary key
            $table->primary('id');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('siswa', function (Blueprint $table) {
            // Kembalikan tipe kolom id menjadi integer (jika Anda sebelumnya menggunakan integer auto-increment)
            $table->bigIncrements('id')->change();
        });
    }
};
