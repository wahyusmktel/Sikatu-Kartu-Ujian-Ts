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
        Schema::table('data_ujian', function (Blueprint $table) {
            $table->string('kode_ujian')->nullable(); // Menambahkan kolom kode_ujian dengan tipe string
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('data_ujian', function (Blueprint $table) {
            $table->dropColumn('kode_ujian'); // Menghapus kolom kode_ujian
        });
    }

};
