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
        Schema::create('mapel_cbt', function (Blueprint $table) {
            $table->uuid('id')->primary();  // UUID untuk kolom id
            $table->string('category')->nullable();  // kolom category dengan tipe string, namun bisa menerima angka
            $table->string('format')->nullable();  // kolom format dengan tipe string
            $table->string('shortname')->nullable();  // kolom shortname dengan tipe string
            $table->string('fullname')->nullable();  // kolom fullname dengan tipe string
            $table->boolean('status')->default(true);  // kolom status dengan tipe boolean dan default bernilai true
            $table->timestamps();  // timestamps untuk created_at dan updated_at
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapel_cbt');
    }
};
