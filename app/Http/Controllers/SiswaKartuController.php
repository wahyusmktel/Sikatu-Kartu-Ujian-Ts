<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiswaKartu;

class SiswaKartuController extends Controller
{
    public function index(Request $request)
    {
        $siswaId = auth('siswa')->id(); // ID siswa yang sedang aktif

        // Ambil input cari dan dataPerPage dari request
        $cari = $request->cari;
        $dataPerPage = $request->input('dataPerPage', 10); // default adalah 10 jika tidak ada input

        // Ambil data dari tabel aktivasi_kartu berdasarkan id_siswa yang aktif, dengan fitur cari dan paginasi
        $kartuUjians = SiswaKartu::with(['ujian'])
            ->where('id_siswa', $siswaId)
            ->whereHas('ujian', function ($query) use ($cari) {
                $query->where('status', true);

                if ($cari) {
                    $query->where('nama_ujian', 'like', "%$cari%");
                }
            })
            ->whereHas('kartuUjian', function ($query) {
                $query->where('status_aktivasi', true);
            })
            
            ->paginate($dataPerPage);

            // Ambil kartu ujian terakhir dari siswa ini
            $lastKartuForSiswa = SiswaKartu::with(['ujian'])
            ->where('id_siswa', $siswaId)
            ->latest()
            ->first();

        return view('siswa.kartu', compact('kartuUjians', 'cari', 'lastKartuForSiswa'));
    }


}
