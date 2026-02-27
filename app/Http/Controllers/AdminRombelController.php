<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminRombel;
use App\Models\AdminSiswa;

class AdminRombelController extends Controller
{
    public function index(Request $request)
    {
        $cari        = $request->cari;
        $cariLower   = strtolower("%$cari%");
        $dataPerPage = $request->input('dataPerPage', 10);

        $rombels = AdminRombel::where('status', true)
            ->when($cari, function ($query) use ($cariLower) {
                return $query->whereRaw('LOWER(nama_rombel) LIKE ?', [$cariLower])
                             ->orWhereRaw('LOWER(wali_kelas) LIKE ?', [$cariLower]);
            })
            ->withCount('siswa')
            ->paginate($dataPerPage);

        return view('admin.rombel', compact('rombels', 'cari'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_rombel'    => 'required|string|max:255',
            'tingkat_rombel' => 'required|in:X,XI,XII',
            'wali_kelas'     => 'nullable|string|max:255',
        ]);

        $rombel                 = new AdminRombel;
        $rombel->nama_rombel    = $request->nama_rombel;
        $rombel->tingkat_rombel = $request->tingkat_rombel;
        $rombel->wali_kelas     = $request->wali_kelas;
        $rombel->status         = true;
        $rombel->save();

        return redirect()->route('admin.rombel')->with('success', 'Rombel berhasil ditambahkan!');
    }

    /**
     * Halaman anggota rombel — 2 kolom: anggota saat ini & siswa tanpa rombel.
     */
    public function anggota(Request $request, $id)
    {
        $rombel = AdminRombel::findOrFail($id);

        $cariAnggota  = $request->get('cari_anggota', '');
        $cariTambah   = $request->get('cari_tambah', '');

        // Anggota rombel saat ini (sudah punya rombel_id = $id)
        $anggota = AdminSiswa::where('rombel_id', $id)
            ->when($cariAnggota, function ($q) use ($cariAnggota) {
                $q->where(function ($sub) use ($cariAnggota) {
                    $sub->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($cariAnggota) . '%'])
                        ->orWhereRaw('LOWER(nipd) LIKE ?', ['%' . strtolower($cariAnggota) . '%'])
                        ->orWhereRaw('LOWER(nisn) LIKE ?', ['%' . strtolower($cariAnggota) . '%']);
                });
            })
            ->orderBy('nama')
            ->paginate(15, ['*'], 'page_anggota');

        // Siswa tanpa rombel (rombel_id null)
        $tanpaRombel = AdminSiswa::whereNull('rombel_id')
            ->when($cariTambah, function ($q) use ($cariTambah) {
                $q->where(function ($sub) use ($cariTambah) {
                    $sub->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($cariTambah) . '%'])
                        ->orWhereRaw('LOWER(nipd) LIKE ?', ['%' . strtolower($cariTambah) . '%'])
                        ->orWhereRaw('LOWER(nisn) LIKE ?', ['%' . strtolower($cariTambah) . '%']);
                });
            })
            ->orderBy('nama')
            ->paginate(15, ['*'], 'page_tambah');

        return view('admin.rombel_anggota', compact('rombel', 'anggota', 'tanpaRombel', 'cariAnggota', 'cariTambah'));
    }

    /**
     * Tambahkan siswa ke dalam rombel ini (AJAX).
     */
    public function tambahSiswa(Request $request, $id)
    {
        $rombel = AdminRombel::findOrFail($id);
        $siswa  = AdminSiswa::findOrFail($request->id_siswa);

        $siswa->rombel_id      = $rombel->id;
        $siswa->rombel_saat_ini = $rombel->nama_rombel;
        $siswa->save();

        return response()->json([
            'success' => true,
            'message' => "{$siswa->nama} berhasil ditambahkan ke rombel {$rombel->nama_rombel}.",
        ]);
    }

    /**
     * Keluarkan siswa dari rombel (AJAX).
     */
    public function keluarkanSiswa($id_siswa)
    {
        $siswa = AdminSiswa::findOrFail($id_siswa);
        $nama  = $siswa->nama;

        $siswa->rombel_id       = null;
        $siswa->rombel_saat_ini = null;
        $siswa->save();

        return response()->json([
            'success' => true,
            'message' => "{$nama} berhasil dikeluarkan dari rombel.",
        ]);
    }

    /**
     * Bulk tambah siswa ke rombel (AJAX).
     */
    public function bulkTambahSiswa(Request $request, $id)
    {
        $rombel = AdminRombel::findOrFail($id);
        $ids    = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'Pilih minimal 1 siswa.'], 422);
        }

        AdminSiswa::whereIn('id', $ids)->update([
            'rombel_id'       => $rombel->id,
            'rombel_saat_ini' => $rombel->nama_rombel,
        ]);

        return response()->json([
            'success' => true,
            'count'   => count($ids),
            'message' => count($ids) . ' siswa berhasil ditambahkan ke rombel ' . $rombel->nama_rombel . '.',
        ]);
    }

    /**
     * Bulk keluarkan siswa dari rombel (AJAX).
     */
    public function bulkKeluarkanSiswa(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'Pilih minimal 1 siswa.'], 422);
        }

        AdminSiswa::whereIn('id', $ids)->update([
            'rombel_id'       => null,
            'rombel_saat_ini' => null,
        ]);

        return response()->json([
            'success' => true,
            'count'   => count($ids),
            'message' => count($ids) . ' siswa berhasil dikeluarkan dari rombel.',
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_rombel'    => 'required|string|max:255',
            'tingkat_rombel' => 'required|in:X,XI,XII',
            'wali_kelas'     => 'nullable|string|max:255',
            'status'         => 'required|boolean',
        ]);

        $rombel                 = AdminRombel::findOrFail($id);
        $rombel->nama_rombel    = $request->nama_rombel;
        $rombel->tingkat_rombel = $request->tingkat_rombel;
        $rombel->wali_kelas     = $request->wali_kelas;
        $rombel->status         = $request->status;
        $rombel->save();

        return redirect()->route('admin.rombel')->with('success', 'Rombel berhasil diperbarui!');
    }
}
