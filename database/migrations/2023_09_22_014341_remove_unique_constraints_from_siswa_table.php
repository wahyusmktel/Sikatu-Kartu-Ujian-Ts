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
            // Menghapus batasan unique
            $table->dropUnique(['e-mail']);
            $table->dropUnique(['nik_ayah']);
            $table->dropUnique(['nik_ibu']);
            $table->dropUnique(['nik_wali']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            //
        });
    }
};
