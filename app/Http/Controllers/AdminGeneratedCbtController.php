<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\KartuUjian;
use App\Models\AdminSiswa;
use App\Models\AdminMapelCbt;
use App\Models\AdminRombel;
use App\Models\UserCbt;
use App\Models\AdminUjian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


class AdminGeneratedCbtController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->cari;
        $cariLower = strtolower("%$cari%");
        $dataPerPage = $request->input('dataPerPage', 10);

        $activeUjianId = AdminUjian::where('status', true)->pluck('id')->toArray();
        $users = UserCbt::with(['kartuUjian', 'siswa', 'siswa.rombel'])
            ->whereIn('id_ujian', $activeUjianId)
            ->where('status', true)
            ->when($cari, function ($query) use ($cariLower) {
                return $query->whereHas('kartuUjian', function ($q) use ($cariLower) {
                            $q->whereRaw('LOWER(username_ujian) LIKE ?', [$cariLower])
                              ->orWhereRaw('LOWER(password_ujian) LIKE ?', [$cariLower]);
                        })
                        ->orWhereHas('siswa', function ($q) use ($cariLower) {
                            $q->whereRaw('LOWER(nama) LIKE ?', [$cariLower])
                              ->orWhereRaw('LOWER("e-mail") LIKE ?', [$cariLower]);
                        })
                        ->orWhereHas('siswa.rombel', function ($q) use ($cariLower) {
                            $q->whereRaw('LOWER(nama_rombel) LIKE ?', [$cariLower]);
                        });
            })
            ->paginate($dataPerPage);

        // Daftar rombel aktif untuk modal generate
        $rombels = AdminRombel::where('status', true)->orderBy('tingkat_rombel')->orderBy('nama_rombel')->get();

        return view('admin.generated_cbt', compact('users', 'cari', 'rombels'));
    }



    public function generateUserCbt(Request $request)
    {
        DB::beginTransaction();

        try {
            // Ambil array ruang (bisa semua kosong — tidak wajib diisi semua rombel)
            $ruangPerRombel = $request->input('ruang', []);

            $dataUjian = AdminUjian::where('status', true)->first();
            if (!$dataUjian) {
                return redirect()->route('admin.generated_cbt')->with('error', 'Tidak ada ujian aktif. Aktifkan ujian terlebih dahulu.');
            }

            $kartuUjians = KartuUjian::with('siswa')->get();

            if ($kartuUjians->isEmpty()) {
                return redirect()->route('admin.generated_cbt')->with('error', 'Belum ada kartu ujian yang terdaftar.');
            }

            $totalProses = 0;

            foreach ($kartuUjians as $kartu) {
                $siswa = $kartu->siswa;

                // Skip jika kartu tidak punya siswa
                if (!$siswa) {
                    \Log::warning('GenerateCBT: KartuUjian ID ' . $kartu->id . ' tidak memiliki siswa.');
                    continue;
                }

                // Tentukan nama ruang berdasarkan rombel_id siswa
                $namaRuang = '-';
                if ($siswa->rombel_id && array_key_exists($siswa->rombel_id, $ruangPerRombel)) {
                    $filled = trim($ruangPerRombel[$siswa->rombel_id]);
                    if ($filled !== '') {
                        $namaRuang = $filled;
                    }
                }

                $mapels = AdminMapelCbt::where('id_rombel', $siswa->rombel_id)
                    ->where('id_ujian', $dataUjian->id)
                    ->get();

                $courses = [];
                foreach ($mapels as $index => $mapel) {
                    $fullnameCleaned  = str_replace(',', '_', $mapel->fullname);
                    $shortnameSegment = strtoupper(Str::slug($mapel->rombel->tingkat_rombel, '_'));
                    $fullname2        = $fullnameCleaned . ' Kelas ' . str_replace('_', ' ', $shortnameSegment);
                    $shortname        = $mapel->shortname . '_' . $fullname2;
                    $courses['course' . ($index + 1)] = $shortname;
                }

                $existingUserCbt = UserCbt::where('id_siswa', $siswa->id)
                    ->where('id_ujian', $dataUjian->id)
                    ->first();

                $dataToSave = [
                    'id_kartu_ujian' => $kartu->id,
                    'id_siswa'       => $siswa->id,
                    'address'        => $namaRuang,
                    'id_ujian'       => $dataUjian->id,
                    'status'         => true,
                ] + $courses;

                if ($existingUserCbt) {
                    $existingUserCbt->update($dataToSave);
                    \Log::info('GenerateCBT: UPDATE siswa ' . $siswa->nama . ' ruang=' . $namaRuang);
                } else {
                    UserCbt::create($dataToSave);
                    \Log::info('GenerateCBT: CREATE siswa ' . $siswa->nama . ' ruang=' . $namaRuang);
                }

                $totalProses++;
            }

            DB::commit();
            return redirect()->route('admin.generated_cbt')->with('success', "Data user CBT berhasil di-generate. Total: {$totalProses} siswa diproses.");

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('GenerateCBT Error: ' . $e->getMessage() . ' | ' . $e->getFile() . ':' . $e->getLine());
            return redirect()->route('admin.generated_cbt')->with('error', 'Ada masalah: ' . $e->getMessage());
        }
    }

    public function exportToCSV()
    {

        // Mengambil ID ujian dengan status true
        $activeUjianId = AdminUjian::where('status', true)->pluck('id')->toArray();

        // Memfilter user berdasarkan ID ujian aktif
        $users = UserCbt::with(['kartuUjian', 'siswa', 'siswa.rombel'])
        ->whereIn('id_ujian', $activeUjianId)
        ->where('status', true)  // Menambahkan filter berdasarkan status
        ->get();

        // $users = UserCbt::with(['kartuUjian', 'siswa', 'siswa.rombel'])->get();

        $filename = "export_user_cbt_" . now()->format('Y_m_d_H_i_s') . ".csv";
        $tempPath = tempnam(sys_get_temp_dir(), 'export_');
        $handle = fopen($tempPath, 'w+');

        // Menambahkan header ke CSV
        fputcsv($handle, [
            'username', 'password', 'firstname', 'lastname', 'email', 'department',
            'address', 'course1', 'course2', 'course3', 'course4', 'course5',
            'course6', 'course7', 'course8', 'course9', 'course10', 'course11',
            'course12', 'course13', 'course14', 'course15'
        ]);

        foreach ($users as $user) {
            $names = explode(' ', $user->siswa->nama, 2); // memecah nama menjadi dua bagian
            $firstname = $names[0];
            $lastname = isset($names[1]) ? $names[1] : $firstname;

            $fields = [
                // "'" . $user->kartuUjian->username_ujian,
                sprintf('%05s', $user->kartuUjian->username_ujian),
                // $user->kartuUjian->password_ujian,
                // sprintf('%05s', $user->kartuUjian->password_ujian),
                "'" . $user->kartuUjian->password_ujian,
                $firstname,
                $lastname,
                $user->siswa['e-mail'],
                $user->siswa->rombel->nama_rombel,
                $user->address,
                $user->course1,
                $user->course2,
                $user->course3,
                $user->course4,
                $user->course5,
                $user->course6,
                $user->course7,
                $user->course8,
                $user->course9,
                $user->course10,
                $user->course11,
                $user->course12,
                $user->course13,
                $user->course14,
                $user->course15
            ];

            fputcsv($handle, $fields);
        }

        fclose($handle);

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->download($tempPath, $filename, $headers)->deleteFileAfterSend(true);
    }


}
