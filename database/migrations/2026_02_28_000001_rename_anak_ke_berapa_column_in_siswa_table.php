<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Rename kolom 'anak_ke-berapa' (hyphen) → 'anak_ke_berapa' (underscore)
     * agar konsisten dengan konvensi penamaan kolom MySQL dan tidak konflik
     * saat insert menggunakan Eloquent/Query Builder.
     */
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->renameColumn('anak_ke-berapa', 'anak_ke_berapa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            $table->renameColumn('anak_ke_berapa', 'anak_ke-berapa');
        });
    }
};
