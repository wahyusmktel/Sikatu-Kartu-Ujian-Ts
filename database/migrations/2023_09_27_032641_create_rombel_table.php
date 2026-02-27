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
        Schema::create('rombel', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_rombel')->nullable();
            $table->string('tingkat_rombel')->nullable(); // Misalnya: X, XI, XII
            $table->string('wali_kelas')->nullable();
            $table->boolean('status')->default(true); // Otomatis akan bernilai true saat penambahan
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rombel');
    }
};
