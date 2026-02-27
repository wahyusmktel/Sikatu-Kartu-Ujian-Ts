<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KartuUjian;
use App\Models\AdminUjian;
use App\Models\AdminSiswa;

class AdminGeneratedKartuController extends Controller
{   

    public function index(Request $request)
    {
        $cari = $request->cari;
        $dataPerPage = $request->input('dataPerPage', 10);

        // Ambil data kartu ujian dengan relasi ujian dan siswa
        $kartuUjians = KartuUjian::with(['ujian', 'siswa'])
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
        ->paginate($dataPerPage);


        // Ambil data ujian yang statusnya true
        $ujianAktif = AdminUjian::where('status', true)->first();

        // Ambil semua siswa
        $semuaSiswa = AdminSiswa::all();

        return view('admin.kartu', compact('kartuUjians', 'cari', 'ujianAktif', 'semuaSiswa'));
    }


    public function generate(Request $request)
    {
        $request->validate([
            'id_ujian' => 'required|exists:data_ujian,id',
            'siswa_option' => 'required|in:all_siswa,exclude_siswa',
            'siswa_exclude' => 'sometimes|array'
        ]);

        $ujian = AdminUjian::find($request->id_ujian);
        if (!$ujian) {
            return redirect()->back()->with('error', 'Tidak ada ujian yang aktif.');
        }

        \DB::beginTransaction();
        try {
            // 1. Jika memilih kecualikan siswa, hapus kartu ujian yang sudah ada untuk siswa yang dikecualikan tersebut
            if ($request->siswa_option == 'exclude_siswa' && !empty($request->siswa_exclude)) {
                KartuUjian::where('id_ujian', $ujian->id)
                    ->whereIn('id_siswa', $request->siswa_exclude)
                    ->delete();
            }

            // 2. Tentukan daftar siswa yang akan di-generate/update
            $siswaQuery = AdminSiswa::query();
            if ($request->siswa_option == 'exclude_siswa' && !empty($request->siswa_exclude)) {
                $siswaQuery->whereNotIn('id', $request->siswa_exclude);
            }
            $siswas = $siswaQuery->get();

            // 3. Proses generate atau update (tanpa mengubah username/password jika sudah ada)
            foreach ($siswas as $siswa) {
                // Cek apakah sudah ada kartu untuk siswa ini di ujian ini
                $exists = KartuUjian::where('id_ujian', $ujian->id)
                    ->where('id_siswa', $siswa->id)
                    ->first();

                if (!$exists) {
                    // Jika belum ada, buat baru dengan username & password random
                    $username = 'TS' . str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
                    $password = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);

                    KartuUjian::create([
                        'id_ujian'       => $ujian->id,
                        'id_siswa'       => $siswa->id,
                        'username_ujian' => $username,
                        'password_ujian' => $password,
                        'status'         => false
                    ]);
                }
                // Jika sudah ada, biarkan saja (sesuai permintaan: jangan lakukan penambahan data baru, jangan ubah username & password)
            }

            \DB::commit();
            return redirect()->route('admin.kartu')->with('success', 'Data kartu ujian berhasil diperbarui.');
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

}
