<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use App\Models\AdminSiswa;
use App\Models\AdminRombel;

class RombelIdUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $siswas = AdminSiswa::all();

        foreach ($siswas as $siswa) {
            $rombel = AdminRombel::where('nama_rombel', $siswa->rombel_saat_ini)->first();

            if ($rombel) {
                $siswa->rombel_id = $rombel->id;
                $siswa->save();
            }
        }
        
        
    }
}
