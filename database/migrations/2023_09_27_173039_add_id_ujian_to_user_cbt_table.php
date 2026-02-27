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
        Schema::table('user_cbt', function (Blueprint $table) {
            $table->uuid('id_ujian')->after('id_siswa')->nullable();
            $table->foreign('id_ujian')->references('id')->on('data_ujian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('user_cbt', function (Blueprint $table) {
            $table->dropForeign(['id_ujian']);
            $table->dropColumn('id_ujian');
        });
    }
};
