<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminRombel;


class AdminRombelController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->cari; // Parameter pencarian

        $cariLower = strtolower("%$cari%");

        $dataPerPage = $request->input('dataPerPage', 10); // Jumlah data per halaman, default adalah 10

        // Query pencarian
        $rombels = AdminRombel::where('status', true)
            ->when($cari, function($query) use ($cariLower) {
                return $query->whereRaw('LOWER(nama_rombel) LIKE ?', [$cariLower])
                            ->orWhereRaw('LOWER(wali_kelas) LIKE ?', [$cariLower]);
            })
            ->paginate($dataPerPage);

        return view('admin.rombel', compact('rombels', 'cari'));
    }

    public function store(Request $request)
    {
        // Validasi data masukan (opsional)
        $validatedData = $request->validate([
            'nama_rombel' => 'required|string|max:255',
            'tingkat_rombel' => 'required|in:X,XI,XII', // validasi bahwa hanya X, XI, atau XII yang diperbolehkan
            'wali_kelas' => 'nullable|string|max:255'
        ]);

        // Membuat record baru di tabel rombel
        $rombel = new AdminRombel;
        $rombel->nama_rombel = $request->nama_rombel;
        $rombel->tingkat_rombel = $request->tingkat_rombel;
        $rombel->wali_kelas = $request->wali_kelas;
        $rombel->status = true; // set status menjadi true
        $rombel->save();

        // Mengembalikan respons ke halaman sebelumnya dengan pesan sukses (atau Anda dapat mengarahkan ke halaman lain yang Anda inginkan)
        return redirect()->route('admin.rombel')->with('success', 'Data berhasil ditambahkan!');
    }

    
}
