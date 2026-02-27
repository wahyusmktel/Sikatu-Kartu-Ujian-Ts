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
        $cari        = $request->cari;
        $cariLower   = strtolower("%$cari%");
        $dataPerPage = $request->input('dataPerPage', 10);

        $allSiswa = AdminSiswa::orderBy('nama')->get();

        $activeUjianId = AdminUjian::where('status', true)->pluck('id')->toArray();
        $users = UserCbtSusulan::with(['kartuUjian', 'siswa', 'siswa.rombel'])
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

        return view('admin.generated_cbt_susulan', compact('users', 'cari', 'allSiswa'));
    }

    public function generateUserCbtSusulan(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'address'   => 'required|string|max:255',
                'siswa_ids' => 'required|array|min:1',
            ], [
                'address.required'   => 'Nama ruang wajib diisi.',
                'siswa_ids.required' => 'Pilih minimal 1 siswa.',
                'siswa_ids.min'      => 'Pilih minimal 1 siswa.',
            ]);

            $dataUjian = AdminUjian::where('status', true)->first();
            if (!$dataUjian) {
                return redirect()->route('admin.generated_cbt_susulan')
                    ->with('error', 'Tidak ada ujian aktif. Aktifkan ujian terlebih dahulu.');
            }

            $selectedSiswaIds = $request->input('siswa_ids');
            $kartuUjians = KartuUjian::with('siswa')->whereIn('id_siswa', $selectedSiswaIds)->get();

            if ($kartuUjians->isEmpty()) {
                return redirect()->route('admin.generated_cbt_susulan')
                    ->with('error', 'Siswa yang dipilih belum memiliki kartu ujian.');
            }

            $totalProses = 0;

            foreach ($kartuUjians as $kartu) {
                $siswa = $kartu->siswa;

                if (!$siswa) {
                    \Log::warning('GenerateCBTSusulan: KartuUjian ID ' . $kartu->id . ' tidak memiliki siswa.');
                    continue;
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

                $existingUserCbt = UserCbtSusulan::where('id_siswa', $siswa->id)
                    ->where('id_ujian', $dataUjian->id)
                    ->first();

                $dataToSave = [
                    'id_kartu_ujian' => $kartu->id,
                    'id_siswa'       => $siswa->id,
                    'address'        => trim($request->address),
                    'id_ujian'       => $dataUjian->id,
                    'status'         => true,
                ] + $courses;

                if ($existingUserCbt) {
                    $existingUserCbt->update($dataToSave);
                    \Log::info('GenerateCBTSusulan: UPDATE ' . $siswa->nama);
                } else {
                    UserCbtSusulan::create($dataToSave);
                    \Log::info('GenerateCBTSusulan: CREATE ' . $siswa->nama);
                }

                $totalProses++;
            }

            DB::commit();
            return redirect()->route('admin.generated_cbt_susulan')
                ->with('success', "Generate susulan berhasil. Total: {$totalProses} siswa diproses.");

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('GenerateCBTSusulan Error: ' . $e->getMessage() . ' | ' . $e->getFile() . ':' . $e->getLine());
            return redirect()->route('admin.generated_cbt_susulan')
                ->with('error', 'Ada masalah: ' . $e->getMessage());
        }
    }

    public function exportToCSV()
    {
        $activeUjianId = AdminUjian::where('status', true)->pluck('id')->toArray();

        $users = UserCbtSusulan::with(['kartuUjian', 'siswa', 'siswa.rombel'])
            ->whereIn('id_ujian', $activeUjianId)
            ->where('status', true)
            ->get();

        $filename = "export_user_cbt_susulan_" . now()->format('Y_m_d_H_i_s') . ".csv";
        $tempPath = tempnam(sys_get_temp_dir(), 'export_');
        $handle   = fopen($tempPath, 'w+');

        fputcsv($handle, [
            'username', 'password', 'firstname', 'lastname', 'email', 'department',
            'address', 'course1', 'course2', 'course3', 'course4', 'course5',
            'course6', 'course7', 'course8', 'course9', 'course10', 'course11',
            'course12', 'course13', 'course14', 'course15',
        ]);

        foreach ($users as $user) {
            $names     = explode(' ', $user->siswa->nama, 2);
            $firstname = $names[0];
            $lastname  = $names[1] ?? $firstname;

            fputcsv($handle, [
                sprintf('%05s', $user->kartuUjian->username_ujian),
                "'" . $user->kartuUjian->password_ujian,
                $firstname,
                $lastname,
                $user->siswa['e-mail'],
                optional($user->siswa->rombel)->nama_rombel ?? '-',
                $user->address,
                $user->course1,  $user->course2,  $user->course3,  $user->course4,  $user->course5,
                $user->course6,  $user->course7,  $user->course8,  $user->course9,  $user->course10,
                $user->course11, $user->course12, $user->course13, $user->course14, $user->course15,
            ]);
        }

        fclose($handle);

        return response()->download($tempPath, $filename, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ])->deleteFileAfterSend(true);
    }
}
