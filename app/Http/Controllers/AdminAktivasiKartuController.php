<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KartuUjian;
use App\Models\AdminUjian;
use App\Models\AdminSiswa;
use App\Models\AdminAktivasiKartu;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SiswaAktivasiExport;
use App\Exports\SiswaBelumAktivasiExport;

class AdminAktivasiKartuController extends Controller
{
    public function index(Request $request)
    {
        $totalAktivasi = KartuUjian::whereHas('ujian', function($query) {
            $query->where('status', true);
        })
        ->whereHas('aktivasiKartu', function($q) {
            $q->where('status_aktivasi', true);
        })->count();

        $totalBelumAktivasi = KartuUjian::whereHas('ujian', function($query) {
            $query->where('status', true);
        })
        ->where(function($q) {
            // Siswa yang memiliki status aktivasi = false
            $q->whereHas('aktivasiKartu', function($subQuery) {
                $subQuery->where('status_aktivasi', false);
            })
            // Atau siswa yang sama sekali belum memiliki record di tabel aktivasi
            ->orWhereDoesntHave('aktivasiKartu');
        })->count();        
        
        $cari = $request->cari;
        $dataPerPage = $request->input('dataPerPage', 10);
        $statusFilter = $request->input('status_filter');

        // Ambil data kartu ujian dengan relasi ujian dan siswa
        $kartuUjians = KartuUjian::with(['ujian', 'siswa', 'aktivasiKartu'])
            ->whereHas('ujian', function($query) {
                $query->where('status', true);
            })
            ->when($cari, function($query) use ($cari) {
                $cariLower = strtolower("%$cari%");
                return $query->where(function($subQuery) use ($cariLower) {
                    $subQuery->whereHas('ujian', function($q) use ($cariLower) {
                        $q->whereRaw('LOWER(nama_ujian) LIKE ?', [$cariLower])
                          ->where('status', true);
                    })
                    ->orWhereHas('siswa', function($q) use ($cariLower) {
                        $q->whereRaw('LOWER(nama) LIKE ?', [$cariLower])
                        ->orWhereRaw('LOWER(rombel_saat_ini) LIKE ?', [$cariLower]);
                    })
                    ->orWhereRaw('LOWER(username_ujian) LIKE ?', [$cariLower])
                    ->orWhereRaw('LOWER(password_ujian) LIKE ?', [$cariLower]);
                });
            })            
            

            ->when($statusFilter, function($query) use ($statusFilter) {
                if ($statusFilter == "true") {
                    return $query->whereHas('aktivasiKartu', function($q) {
                        $q->where('status_aktivasi', true);
                    });
                } else if ($statusFilter == "false") {
                    return $query->where(function($q) {
                        $q->whereHas('aktivasiKartu', function($subQuery) {
                            $subQuery->where('status_aktivasi', false);
                        })
                        ->orWhereDoesntHave('aktivasiKartu');
                    });
                }
            })

            ->paginate($dataPerPage);

        // Ambil data ujian yang statusnya true
        $ujianAktif = AdminUjian::where('status', true)->first();

        // Ambil semua siswa
        $semuaSiswa = AdminSiswa::all();

        return view('admin.aktivasi', compact('kartuUjians', 'cari', 'ujianAktif', 'semuaSiswa', 'statusFilter', 'totalAktivasi', 'totalBelumAktivasi'));
    }
    
    public function insert(Request $request)
    {
        try {
            $status = filter_var($request->status_aktivasi, FILTER_VALIDATE_BOOLEAN);

            // Cek apakah id_kartu sudah ada di tabel aktivasi_kartu
            $aktivasiKartu = AdminAktivasiKartu::where('id_kartu', $request->id_kartu)->first();
    
            if($aktivasiKartu) {
                $aktivasiKartu->update(['status_aktivasi' => $status]);
            } else {
                // Jika id_kartu belum ada di tabel aktivasi_kartu, insert data baru
                AdminAktivasiKartu::create([
                    'id_kartu' => $request->id_kartu,
                    'id_ujian' => $request->id_ujian,
                    'id_siswa' => $request->id_siswa,
                    'status_aktivasi' => $status
                ]);
            }
    
            if ($status) {
                return response()->json(['success' => true, 'message' => 'Kartu ujian berhasil diaktifkan!'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Kartu Ujian berhasil di non-aktifkan.'], 200);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Update Aktivasi Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage(), 'error' => $e->getMessage()], 200);
        }
    }

    public function exportSiswaAktivasi()
    {
        return Excel::download(new SiswaAktivasiExport, 'siswa_aktivasi.xlsx');
    }

    public function exportSiswaBelumAktivasi()
    {
        return Excel::download(new SiswaBelumAktivasiExport, 'siswa_belum_aktivasi.xlsx');
    }


}
