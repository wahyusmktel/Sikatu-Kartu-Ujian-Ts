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
        Schema::create('data_ujian', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID sebagai primary key
            $table->string('nama_ujian');
            $table->string('tahun_pelajaran');
            $table->string('semester');
            $table->string('link_ujian');
            $table->date('tgl_mulai');
            $table->date('tgl_akhir');
            $table->boolean('status')->default(false); // Default false saat input data
            $table->timestamps(); // Menghasilkan created_at dan updated_at
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_ujian');
    }
};
