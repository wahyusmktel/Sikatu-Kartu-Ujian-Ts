<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\AdminSiswa;
use App\Models\KartuUjian;
use App\Models\UserCbt;
use App\Models\UserCbtSusulan;
use App\Models\AdminAktivasiKartu;
use App\Imports\SiswaImport;
use Maatwebsite\Excel\Facades\Excel;

class AdminSiswaController extends Controller
{
    public function show()
    {
        return view('admin.siswa');
    }

    public function importExcel(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls'
            ], [
                'file.required' => 'File harus dipilih terlebih dahulu.',
                'file.mimes'    => 'Format file tidak valid. Hanya file xlsx dan xls yang diperbolehkan.'
            ]);

            Excel::import(new SiswaImport, $request->file('file'));

            return redirect()->back()->with('success', 'Data berhasil diimpor!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }

    public function index(Request $request)
    {
        $cari = $request->cari;

        $cariLower = strtolower("%$cari%");

        $dataPerPage = $request->input('dataPerPage', 10);

        $siswa = AdminSiswa::when($cari, function($query) use ($cariLower) {
            return $query->whereRaw('LOWER(nama) LIKE ?', [$cariLower])
                         ->orWhereRaw('LOWER(nisn) LIKE ?', [$cariLower])
                         ->orWhereRaw('LOWER(nipd) LIKE ?', [$cariLower])
                         ->orWhereRaw('LOWER("e-mail") LIKE ?', [$cariLower])
                         ->orWhereRaw('LOWER(nik) LIKE ?', [$cariLower]);
        })
        ->paginate($dataPerPage);

        return view('admin.siswa', compact('siswa', 'cari'));
    }

    public function edit($id)
    {
        $siswa = AdminSiswa::findOrFail($id);
        return view('admin.siswa_edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = AdminSiswa::findOrFail($id);

        $request->validate([
            'nama'            => 'required|string|max:255',
            'nipd'            => 'nullable|string|max:50',
            'nisn'            => 'nullable|string|max:50',
            'e-mail'          => 'nullable|email|max:255',
            'nik'             => 'nullable|string|max:20',
            'jk'              => 'nullable|string|max:20',
            'tempat_lahir'    => 'nullable|string|max:100',
            'tanggal_lahir'   => 'nullable|date',
            'agama'           => 'nullable|string|max:50',
            'alamat'          => 'nullable|string',
            'hp'              => 'nullable|string|max:20',
            'rombel_saat_ini' => 'nullable|string|max:100',
        ]);

        $data = $request->except(['_token', '_method']);

        $siswa->update($data);

        return redirect()->route('admin.siswa')->with('success', 'Data siswa berhasil diperbarui!');
    }

    /**
     * Endpoint AJAX: cek data relasi siswa sebelum dihapus.
     * Mengembalikan JSON berisi jumlah dan ringkasan data terkait.
     */
    public function cekRelasi($id)
    {
        $siswa = AdminSiswa::findOrFail($id);

        $kartuUjian    = KartuUjian::where('id_siswa', $id)->get();
        $kartuIds      = $kartuUjian->pluck('id');

        $jumlahKartu        = $kartuUjian->count();
        $jumlahAktivasi     = AdminAktivasiKartu::where('id_siswa', $id)->count();
        $jumlahUserCbt      = UserCbt::where('id_siswa', $id)->count();
        $jumlahUserCbtSusulan = UserCbtSusulan::where('id_siswa', $id)->count();

        $relasi = [];

        if ($jumlahKartu > 0) {
            $relasi[] = [
                'label'   => 'Kartu Ujian',
                'jumlah'  => $jumlahKartu,
                'detail'  => $kartuUjian->map(fn($k) => 'Username: ' . $k->username_ujian)->values()->toArray(),
            ];
        }
        if ($jumlahAktivasi > 0) {
            $relasi[] = [
                'label'   => 'Aktivasi Kartu',
                'jumlah'  => $jumlahAktivasi,
                'detail'  => [],
            ];
        }
        if ($jumlahUserCbt > 0) {
            $relasi[] = [
                'label'   => 'Akun CBT (user_cbt)',
                'jumlah'  => $jumlahUserCbt,
                'detail'  => [],
            ];
        }
        if ($jumlahUserCbtSusulan > 0) {
            $relasi[] = [
                'label'   => 'Akun CBT Susulan (user_cbt_susulan)',
                'jumlah'  => $jumlahUserCbtSusulan,
                'detail'  => [],
            ];
        }

        return response()->json([
            'nama'         => $siswa->nama,
            'ada_relasi'   => count($relasi) > 0,
            'relasi'       => $relasi,
        ]);
    }

    /**
     * Hapus data siswa beserta semua data relasinya secara bertahap (cascade manual).
     */
    public function destroy($id)
    {
        $siswa = AdminSiswa::findOrFail($id);
        $nama  = $siswa->nama;

        DB::transaction(function () use ($id) {
            // 1. Ambil semua kartu ujian milik siswa ini
            $kartuIds = KartuUjian::where('id_siswa', $id)->pluck('id');

            // 2. Hapus user_cbt & susulan yg merujuk ke kartu ujian tersebut
            if ($kartuIds->isNotEmpty()) {
                UserCbt::whereIn('id_kartu_ujian', $kartuIds)->delete();
                UserCbtSusulan::whereIn('id_kartu_ujian', $kartuIds)->delete();
            }

            // 3. Hapus user_cbt & susulan yg langsung merujuk ke id_siswa
            UserCbt::where('id_siswa', $id)->delete();
            UserCbtSusulan::where('id_siswa', $id)->delete();

            // 4. Hapus aktivasi kartu
            AdminAktivasiKartu::where('id_siswa', $id)->delete();

            // 5. Hapus kartu ujian
            KartuUjian::where('id_siswa', $id)->delete();

            // 6. Hapus siswa
            AdminSiswa::where('id', $id)->delete();
        });

        return redirect()->route('admin.siswa')->with('success', "Data siswa \"{$nama}\" beserta seluruh data relasinya berhasil dihapus!");
    }
}