<?php

namespace App\Http\Controllers;

use App\Models\KartuUjian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Carbon\Carbon;

class KartuUjianController extends Controller
{
    public function cetak($id) {
        $kartu = KartuUjian::with('ujian', 'siswa')->find($id);

        // Jika kartu ujian tidak ditemukan atau belum teraktivasi, redirect ke halaman sebelumnya dengan pesan error
        // if (!$kartu || !$kartu->aktivasiKartu || !$kartu->aktivasiKartu->status_aktivasi) {
        //     return redirect()->back()->with('error', 'Kartu ujian belum teraktivasi atau tidak ditemukan.');
        // }

        // Jika kartu ujian tidak ditemukan, belum teraktivasi, atau ujian tidak aktif, redirect ke halaman sebelumnya dengan pesan error
        if (!$kartu || !$kartu->aktivasiKartu || !$kartu->aktivasiKartu->status_aktivasi || !$kartu->ujian->status) {
            return redirect()->back()->with('error', 'Kartu ujian belum teraktivasi, ujian tidak aktif, atau kartu ujian tidak ditemukan.');
        }

        // Update tgl_download_kartu setelah cetak kartu berhasil
        $kartu->aktivasiKartu->update(['tgl_download_kartu' => Carbon::now()]);

        $tanggalCetak = Carbon::now()->format('d F Y H:i:s') . ' Waktu Indonesia Barat (WIB)';
    
        $pdf = PDF::loadView('admin.cetak_kartu', compact('kartu', 'tanggalCetak'));
        return $pdf->stream('kartu-ujian-' . $kartu->siswa->nama . '.pdf');
    }
}