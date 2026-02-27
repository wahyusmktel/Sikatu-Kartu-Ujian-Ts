<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminDashboardController extends Controller
{
    public function show()
    {
        $totalSiswa = \App\Models\AdminSiswa::count();
        $totalRombel = \App\Models\AdminRombel::count();
        $totalUjian = \App\Models\AdminUjian::where('status', '1')->count();
        $totalMapel = \App\Models\AdminMapelCbt::count();
        $totalCbtUser = \App\Models\UserCbt::count() + \App\Models\UserCbtSusulan::count();
        $totalAktivasi = \App\Models\AdminAktivasiKartu::where('status_aktivasi', 'on')->count();

        // Data for charts
        $siswaPerTingkat = \App\Models\AdminRombel::withCount('siswa')
            ->get()
            ->groupBy('tingkat_rombel')
                ->map(function ($items) {
                return $items->sum('siswa_count');
            });

        $tingkatLabels = $siswaPerTingkat->keys()->toArray();
        $tingkatData = $siswaPerTingkat->values()->toArray();

        // Aktivasi Stats
        $aktivasiOn = \App\Models\AdminAktivasiKartu::where('status_aktivasi', 'on')->count();
        $aktivasiOff = \App\Models\AdminAktivasiKartu::where('status_aktivasi', '!=', 'on')->count();

        return view('admin.dashboard', compact(
            'totalSiswa', 
            'totalRombel', 
            'totalUjian', 
            'totalMapel', 
            'totalCbtUser', 
            'totalAktivasi',
            'tingkatLabels',
            'tingkatData',
            'aktivasiOn',
            'aktivasiOff'
        ));
    }
    
}
