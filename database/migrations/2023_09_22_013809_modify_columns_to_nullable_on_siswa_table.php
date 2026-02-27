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
            $table->string('e-mail')->nullable()->change();
            $table->string('penghasilan_ayah')->nullable()->change();
            $table->string('penghasilan_ibu')->nullable()->change();
            $table->string('nik_ibu')->nullable()->change();
            $table->string('penghasilan_wali')->nullable()->change();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nullable_on_siswa', function (Blueprint $table) {
            //
        });
    }
};
