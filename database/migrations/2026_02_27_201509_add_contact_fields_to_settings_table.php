<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('no_hp_cs', 20)->nullable()->after('no_hp_sekolah');
            $table->string('no_hp_admin', 20)->nullable()->after('no_hp_cs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['no_hp_cs', 'no_hp_admin']);
        });
    }
};
