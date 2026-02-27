<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdminSettings;

class AdminSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        AdminSettings::create([
            'nama_sekolah'   => 'SMK Telkom Lampung',
            'nama_kepsek'    => 'Adang Wihanda, S.T.',
            'no_hp_sekolah'  => '08117208814',
            'email_sekolah'  => 'admin@smktelkom-lpg.sch.id',
            'logo_sekolah'   => 'path/to/logo.png', // Anda bisa menggantinya dengan path sebenarnya nantinya
            'npsn'           => '69944770',
            'alamat_sekolah' => 'Jl. Raya Gadingrejo, Gading Rejo, Kec. Gading Rejo, Kabupaten Pringsewu, Lampung 35372',
            'status'         => true
        ]);
    }
}
