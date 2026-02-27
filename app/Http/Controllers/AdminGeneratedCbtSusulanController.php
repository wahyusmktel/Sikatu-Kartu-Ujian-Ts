<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KartuUjian;
use App\Models\AdminMapelCbt;
use App\Models\UserCbtSusulan;
use App\Models\AdminUjian;
use App\Models\AdminSiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class AdminGeneratedCbtSusulanController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->cari; 
        $cariLower = strtolower("%$cari%");
        $dataPerPage = $request->input('dataPerPage', 10);

        // Mengambil semua data siswa
        $allSiswa = AdminSiswa::all();

        // Filter berdasarkan ujian yang aktif
        $activeUjianId = AdminUjian::where('status', true)->pluck('id')->toArray();
        $users = UserCbtSusulan::with(['kartuUjian', 'siswa', 'siswa.rombel'])
            ->whereIn('id_ujian', $activeUjianId)
            ->where('status', true)  // Menambahkan filter berdasarkan status
            ->when($cari, function($query) use ($cariLower) {
                return $query->whereHas('kartuUjian', function($q) use ($cariLower) {
                            $q->whereRaw('LOWER(username_ujian) LIKE ?', [$cariLower])
                            ->orWhereRaw('LOWER(password_ujian) LIKE ?', [$cariLower]);
                        })
                        ->orWhereHas('siswa', function($q) use ($cariLower) {
                            $q->whereRaw('LOWER(nama) LIKE ?', [$cariLower])
                            ->orWhereRaw('LOWER("e-mail") LIKE ?', [$cariLower]);
                        })
                        ->orWhereHas('siswa.rombel', function($q) use ($cariLower) {
                            $q->whereRaw('LOWER(nama_rombel) LIKE ?', [$cariLower]);
                        });
            })
            ->paginate($dataPerPage);

        return view('admin.generated_cbt_susulan', compact('users', 'cari', 'allSiswa'));
    }



    public function generateUserCbtSusulan(Request $request) {
        DB::beginTransaction();
    
        try {
            $request->validate([
                'address' => 'required',
                'siswa_ids' => 'required|array'
            ]);

            // Mengambil id dari DataUjian dengan status true
            $dataUjian = AdminUjian::where('status', true)->first();

            // Jika tidak ada data ujian dengan status true, kembalikan pesan kesalahan
            if (!$dataUjian) {
                return redirect()->route('admin.generated_cbt_susulan')->with('error', 'Tidak ada data ujian dengan status true.');
            }

            $selectedSiswaIds = $request->input('siswa_ids');
    
            $kartuUjians = KartuUjian::whereIn('id_siswa', $selectedSiswaIds)->get();

            $updatesRequired = false; // Menandai jika ada pembaruan yang diperlukan
    
            foreach ($kartuUjians as $kartu) {
                $siswa = $kartu->siswa;
    
                // $mapels = AdminMapelCbt::where('id_rombel', $siswa->rombel_id)->get();
                $mapels = AdminMapelCbt::where('id_rombel', $siswa->rombel_id)
                    ->where('id_ujian', $dataUjian->id)
                    ->get();

                $courses = [];

                foreach ($mapels as $index => $mapel) {
                    $fullnameCleaned = str_replace(',', '_', $mapel->fullname);
                    $shortnameSegment2 = strtoupper(Str::slug($mapel->rombel->tingkat_rombel, '_'));
                    $fullname2 = $fullnameCleaned . ' Kelas ' . str_replace('_', ' ', $shortnameSegment2);
                    $shortname = $mapel->shortname . '_' . $fullname2;

                    $courses['course' . ($index + 1)] = $shortname;
                }

                $existingUserCbtSusulan = UserCbtSusulan::where('id_siswa', $siswa->id)->where('id_ujian', $dataUjian->id)->first();

                // Data untuk insert atau update
                $dataToSave = [
                    'id_kartu_ujian' => $kartu->id,
                    'id_siswa' => $siswa->id,
                    'address' => $request->address,
                    'id_ujian' => $dataUjian->id
                ] + $courses;
    
                if ($existingUserCbtSusulan) {
                    $existingUserCbtSusulan->update($dataToSave);
                } else {
                    UserCbtSusulan::create($dataToSave);
                }
            }

            // Jika ada pembaruan yang diperlukan, kembalikan ke view dengan pesan konfirmasi
            if ($updatesRequired) {
                return redirect()->route('admin.generated_cbt_susulan')->with('updateConfirmationNeeded', true);
            }
    
            DB::commit();
            return redirect()->route('admin.generated_cbt_susulan')->with('success', 'Data user CBT berhasil di-generate.');
            
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('admin.generated_cbt_susulan')->with('error', 'Ada masalah: ' . $e->getMessage());
        }
    }

    public function exportToCSV()
    {

        // Mengambil ID ujian dengan status true
        $activeUjianId = AdminUjian::where('status', true)->pluck('id')->toArray();

        // Memfilter user berdasarkan ID ujian aktif
        $users = UserCbtSusulan::with(['kartuUjian', 'siswa', 'siswa.rombel'])
        ->whereIn('id_ujian', $activeUjianId)
        ->where('status', true)  // Menambahkan filter berdasarkan status
        ->get();

        // $users = UserCbtSusulan::with(['kartuUjian', 'siswa', 'siswa.rombel'])->get();

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
                $user->course15,
                $user->course16,
                $user->course17,
                $user->course18,
                $user->course19,
                $user->course20,
                $user->course21,
                $user->course22,
                $user->course23,
                $user->course24,
                $user->course25,
                $user->course26,
                $user->course27,
                $user->course28,
                $user->course29,
                $user->course30
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
