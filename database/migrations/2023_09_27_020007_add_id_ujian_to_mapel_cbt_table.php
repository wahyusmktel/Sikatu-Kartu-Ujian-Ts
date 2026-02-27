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
        Schema::table('mapel_cbt', function (Blueprint $table) {
            $table->uuid('id_ujian')->after('id')->nullable(); // Menambahkan kolom id_ujian setelah kolom id

            // Membuat foreign key constraint
            $table->foreign('id_ujian')->references('id')->on('data_ujian')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('mapel_cbt', function (Blueprint $table) {
            // Menghapus foreign key constraint
            $table->dropForeign(['id_ujian']);
            
            // Menghapus kolom id_ujian
            $table->dropColumn('id_ujian');
        });
    }

};
