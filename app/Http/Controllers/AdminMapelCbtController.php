<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminMapelCbt;
use App\Models\AdminUjian;
use App\Models\AdminRombel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



class AdminMapelCbtController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->cari; // Parameter pencarian

        $cariLower = strtolower("%$cari%");

        $dataPerPage = $request->input('dataPerPage', 10); // Jumlah data per halaman, default adalah 10

        // Query pencarian untuk AdminMapelCbt
        $mapels = AdminMapelCbt::with(['rombel'])
            ->where('status', true)
            ->when($cari, function($query) use ($cariLower) {
                return $query->whereRaw('LOWER(shortname) LIKE ?', [$cariLower])
                            ->orWhereRaw('LOWER(format) LIKE ?', [$cariLower])
                            ->orWhereRaw('LOWER(fullname) LIKE ?', [$cariLower])
                            ->orWhereHas('rombel', function($q) use ($cariLower) {
                                $q->whereRaw('LOWER(nama_rombel) LIKE ?', [$cariLower]);
                            });
            })
            ->paginate($dataPerPage);

        // Ambil semua rombel dengan status true untuk dropdown
        $rombels = AdminRombel::where('status', true)->get();

        return view('admin.mapel_cbt', compact('mapels', 'rombels', 'cari'));
    }
    
    public function store(Request $request)
    {
        // Validasi input data (Anda mungkin ingin menambahkan lebih banyak aturan validasi)
        $request->validate([
            'category' => 'required|string',
            'format' => 'required|string',
            'fullname' => 'required|string',
            'id_rombel' => 'required',
        ]);

        // Mengambil data dari tabel data_ujian dengan status true
        $activeExam = AdminUjian::where('status', true)->first();

        if (!$activeExam) {
            return redirect()->back()->with('error', 'Tidak ada ujian aktif saat ini!');
        }

        // Membuat singkatan untuk shortname
        $words = explode(' ', $request->fullname);
        $acronym = '';
        foreach ($words as $w) {
            $acronym .= $w[0];
        }
        $shortname = $activeExam->kode_ujian . '_' . $activeExam->tahun_pelajaran . '_' . $acronym;

        // Menyimpan data ke tabel mapel_cbt
        // $mapel = new AdminMapelCbt();
        // $mapel->id_ujian = $activeExam->id;
        // $mapel->category = $request->category;
        // $mapel->format = $request->format;
        // $mapel->shortname = $shortname;
        // $mapel->fullname = $request->fullname;
        // $mapel->status = true;
        // $mapel->id_rombel = $request->id_rombel;
        // $mapel->save();

        // Menyimpan data ke tabel mapel_cbt untuk setiap rombel yang dipilih
        foreach ($request->id_rombel as $rombelId) {
            $mapel = new AdminMapelCbt();
            $mapel->id_ujian = $activeExam->id;
            $mapel->category = $request->category;
            $mapel->format = $request->format;
            $mapel->shortname = $shortname; 
            $mapel->fullname = $request->fullname;
            $mapel->status = true;
            $mapel->id_rombel = $rombelId;
            $mapel->save();
        }

        return redirect()->route('admin.mapel_cbt')->with('success', 'Data berhasil ditambahkan!');
    }

    public function exportToCSV()
    {
        $dataUjian = AdminUjian::where('status', true)->first();

        // Cek apakah ada data ujian yang aktif
        if (!$dataUjian) {
            return redirect()->back()->with('error', 'Tidak ada data ujian yang aktif.');
        }

        $mapels = AdminMapelCbt::with(['rombel'])
        ->where('status', true)
        ->where('id_ujian', $dataUjian->id)
        ->get();

        // $mapels = AdminMapelCbt::with(['rombel'])->where('status', true)->get();

        $filename = "export_mapel_cbt_" . now()->format('Y_m_d_H_i_s') . ".csv";
        $tempPath = tempnam(sys_get_temp_dir(), 'export_');
        $handle = fopen($tempPath, 'w+');

        // Menambahkan header ke CSV
        fputcsv($handle, ['category', 'format', 'shortname', 'fullname']);

        foreach ($mapels as $mapel) {
            $shortnameSegment = strtoupper(Str::slug($mapel->rombel->nama_rombel, '_'));
            // $shortname = $mapel->shortname . '_' . $shortnameSegment;
            $fullname = $mapel->fullname . ' Kelas ' . str_replace('_', ' ', $shortnameSegment);

            // $shortnameSegment2 = strtoupper(Str::slug($mapel->rombel->tingkat_rombel, '_'));
            // $fullname2 = $mapel->fullname . ' Kelas ' . str_replace('_', ' ', $shortnameSegment2);
            // $shortname = $mapel->shortname . '_' . $fullname2;

            $fullnameCleaned = str_replace(',', '_', $mapel->fullname);
            $shortnameSegment2 = strtoupper(Str::slug($mapel->rombel->tingkat_rombel, '_'));
            $fullname2 = $fullnameCleaned . ' Kelas ' . str_replace('_', ' ', $shortnameSegment2);
            $shortname = $mapel->shortname . '_' . $fullname2;



            // fputcsv($handle, [$mapel->category, $mapel->format, $shortname, $fullname]);
            fwrite($handle, implode(',', [$mapel->category, $mapel->format, $shortname, $fullname2]) . PHP_EOL);
        }

        fclose($handle);

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->download($tempPath, $filename, $headers)->deleteFileAfterSend(true);
    }

    
}
