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
            $table->uuid('id_rombel')->nullable()->after('id'); // Tambahkan kolom id_rombel setelah kolom id
            $table->foreign('id_rombel')->references('id')->on('rombel'); // Mendefinisikan foreign key relasi dengan tabel rombel
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mapel_cbt', function (Blueprint $table) {
            //
        });
    }
};
