<?php

namespace App\Http\Controllers;

use App\Models\AdminUjian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminUjianController extends Controller
{
    /**
     * Menampilkan daftar ujian.
     */
    public function index(Request $request)
    {
        $cari = $request->cari;

        $dataPerPage = $request->input('dataPerPage', 10);

        $ujian = AdminUjian::when($cari, function($query) use ($cari) {
            return $query->where('nama_ujian', 'like', "%$cari%")
                         ->orWhere('tahun_pelajaran', 'like', "%$cari%");
        })
        ->orderBy('nama_ujian')
        ->paginate($dataPerPage);

        return view('admin.ujian', compact('ujian', 'cari'));
    }

    /**
     * Menyimpan ujian baru ke database.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_ujian'      => 'required',
            'kode_ujian'      => 'required',
            'tahun_pelajaran' => 'required',
            'semester'        => 'required',
            'link_ujian'      => 'required|url',
            'tgl_mulai'       => 'required|date',
            'tgl_akhir'       => 'required|date',
        ]);

        $data['id']     = (string) \Str::uuid();
        $data['status'] = false;

        AdminUjian::create($data);

        return redirect()->route('admin.ujian.index')->with('success', 'Ujian berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit ujian (AJAX — kembalikan JSON data ujian).
     */
    public function edit($id)
    {
        $ujian = AdminUjian::findOrFail($id);

        // Jika ujian sedang aktif, tolak edit
        if ($ujian->status) {
            return response()->json(['error' => 'Ujian sedang aktif, tidak dapat diedit.'], 403);
        }

        return response()->json($ujian);
    }

    /**
     * Update data ujian.
     */
    public function update(Request $request, $id)
    {
        $ujian = AdminUjian::findOrFail($id);

        if ($ujian->status) {
            return redirect()->route('admin.ujian.index')->with('error', 'Ujian sedang aktif, tidak dapat diedit.');
        }

        $data = $request->validate([
            'nama_ujian'      => 'required|string|max:255',
            'kode_ujian'      => 'required|string|max:100',
            'tahun_pelajaran' => 'required|string|max:20',
            'semester'        => 'required',
            'link_ujian'      => 'required|url',
            'tgl_mulai'       => 'required|date',
            'tgl_akhir'       => 'required|date',
        ]);

        $ujian->update($data);

        return redirect()->route('admin.ujian.index')->with('success', 'Data ujian berhasil diperbarui!');
    }

    /**
     * Hapus data ujian.
     */
    public function destroy($id)
    {
        $ujian = AdminUjian::findOrFail($id);

        if ($ujian->status) {
            return redirect()->route('admin.ujian.index')->with('error', 'Ujian sedang aktif, tidak dapat dihapus.');
        }

        $nama = $ujian->nama_ujian;
        $ujian->delete();

        return redirect()->route('admin.ujian.index')->with('success', "Ujian \"{$nama}\" berhasil dihapus!");
    }

    /**
     * Update status ON/OFF ujian.
     */
    public function updateStatus($id, Request $request)
    {
        try {
            DB::beginTransaction();

            // Set semua status ke false
            AdminUjian::where('id', '<>', $id)->update(['status' => false]);

            // Update status ujian tertentu
            $ujian = AdminUjian::findOrFail($id);
            $ujian->status = filter_var($request->status, FILTER_VALIDATE_BOOLEAN);
            $ujian->save();

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            \Illuminate\Support\Facades\Log::error('Update Status Ujian Error: ' . $e->getMessage());
            return response()->json(['success' => false]);
        }
    }
}
