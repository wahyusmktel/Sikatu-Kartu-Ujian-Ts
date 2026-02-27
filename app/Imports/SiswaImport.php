<?php

namespace App\Imports;

use App\Models\AdminSiswa;
use App\Models\AdminRombel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class SiswaImport implements ToModel, WithHeadingRow
{
    /**
     * Cache rombel yang sudah diproses agar tidak query DB berulang kali
     * untuk rombel yang sama di baris yang berbeda.
     * Key: nama_rombel (lowercase), Value: id rombel
     */
    private array $rombelCache = [];

    // =========================================================
    // HELPER METHODS — sanitasi data dari Excel
    // =========================================================

    /**
     * Ambil nilai string, kembalikan null jika kosong / '?' / '-'
     */
    private function str($row, string $key): ?string
    {
        $val = $row[$key] ?? null;
        $clean = trim((string)$val);
        if ($val === null || $clean === '' || $clean === '?' || $clean === '-') {
            return null;
        }
        return $clean;
    }

    /**
     * Ambil nilai tahun (4 digit, range 1920–2099).
     * Nilai di luar range (termasuk 0, 1900) → null.
     */
    private function year($row, string $key): ?int
    {
        $val = $row[$key] ?? null;
        $clean = trim((string)$val);
        if ($clean === '' || $clean === '?') return null;
        $digits = preg_replace('/[^0-9]/', '', $clean);
        if (strlen($digits) !== 4) return null;
        $year = (int)$digits;
        if ($year < 1920 || $year > 2099) return null;
        return $year;
    }

    /**
     * Ambil nilai tanggal, coba parse dari berbagai format (Excel serial & string).
     * Kembalikan string 'Y-m-d' atau null.
     */
    private function date($row, string $key): ?string
    {
        $val = $row[$key] ?? null;
        $clean = trim((string)$val);
        if ($clean === '' || $clean === '?') return null;

        // Excel serial date (integer / float)
        if (is_numeric($val) && (float)$val > 100 && (float)$val < 200000) {
            try {
                $unix = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp((float)$val);
                $date = date('Y-m-d', $unix);
                if ($date > '1900-01-02') return $date;
            } catch (\Throwable $e) {}
        }

        // Parse string tanggal biasa
        try {
            $ts = strtotime($clean);
            if ($ts !== false) {
                $date = date('Y-m-d', $ts);
                if ($date > '1900-01-01') return $date;
            }
        } catch (\Throwable $e) {}

        return null;
    }

    /**
     * Ambil nilai integer dengan validasi range min/max.
     * Strip karakter non-digit. Kembalikan null jika tidak valid.
     */
    private function int($row, string $key, ?int $min = null, ?int $max = null): ?int
    {
        $val = $row[$key] ?? null;
        $clean = trim((string)$val);
        if ($clean === '' || $clean === '?') return null;
        $digits = preg_replace('/[^0-9]/', '', $clean);
        if ($digits === '' || $digits === '0') return null;
        $int = (int)$digits;
        if ($min !== null && $int < $min) return null;
        if ($max !== null && $int > $max) return null;
        return $int;
    }

    /**
     * Ambil nilai decimal/float. Kembalikan null jika tidak valid.
     */
    private function decimal($row, string $key): ?float
    {
        $val = $row[$key] ?? null;
        $clean = trim((string)$val);
        if ($clean === '' || $clean === '?') return null;
        $clean = preg_replace('/[^0-9.\-]/', '', str_replace(',', '.', $clean));
        if ($clean === '' || $clean === '0' || $clean === '0.0') return null;
        return (float)$clean;
    }

    /**
     * Ambil nilai boolean (Ya/Tidak).
     */
    private function bool($row, string $key): bool
    {
        $val = strtolower(trim((string)($row[$key] ?? '')));
        return in_array($val, ['ya', 'yes', '1', 'true', 'on']);
    }

    // =========================================================
    // LOGIKA ROMBEL — auto-create & relasi
    // =========================================================

    /**
     * Parse string rombel_saat_ini menjadi tingkat_rombel dan nama_rombel.
     *
     * Contoh:
     *   "XI TKJ 2"  → tingkat = "XI",  nama = "XI TKJ 2"
     *   "X TJAT"    → tingkat = "X",   nama = "X TJAT"
     *   "XII RPL 1" → tingkat = "XII", nama = "XII RPL 1"
     */
    private function parseRombel(string $rombelStr): array
    {
        $rombelStr = trim($rombelStr);
        $parts     = preg_split('/\s+/', $rombelStr, 2);
        $tingkat   = strtoupper($parts[0]); // Kata pertama: X / XI / XII
        $nama      = $rombelStr;            // Seluruh string: XI TKJ 2

        return ['tingkat' => $tingkat, 'nama' => $nama];
    }

    /**
     * Cari rombel di DB (atau cache). Jika belum ada, buat baru.
     * Kembalikan UUID rombel.
     */
    private function getOrCreateRombel(string $rombelStr): string
    {
        $key = strtolower(trim($rombelStr));

        // Cek cache terlebih dahulu
        if (isset($this->rombelCache[$key])) {
            return $this->rombelCache[$key];
        }

        $parsed = $this->parseRombel($rombelStr);

        // firstOrCreate: cari berdasarkan nama_rombel (case-insensitive via LOWER)
        $rombel = AdminRombel::whereRaw('LOWER(nama_rombel) = ?', [strtolower($parsed['nama'])])
                             ->first();

        if (!$rombel) {
            $rombel = AdminRombel::create([
                'nama_rombel'    => $parsed['nama'],
                'tingkat_rombel' => $parsed['tingkat'],
                'wali_kelas'     => null,  // kosong dulu
                'status'         => true,
            ]);
        }

        // Simpan ke cache
        $this->rombelCache[$key] = $rombel->id;

        return $rombel->id;
    }

    // =========================================================
    // MAIN MODEL METHOD
    // =========================================================

    public function model(array $row)
    {
        // Skip baris tanpa nama
        $nama = $this->str($row, 'nama');
        if (empty($nama)) {
            return null;
        }

        // NIPD / NISN sebagai sumber password default
        $nipd           = $this->str($row, 'nipd');
        $passwordSource = !empty($nipd) ? $nipd : ($this->str($row, 'nisn') ?? 'password123');

        // ===== AUTO-SYNC ROMBEL =====
        $rombelSaatIni = $this->str($row, 'rombel_saat_ini');
        $rombelId      = null;
        if (!empty($rombelSaatIni)) {
            $rombelId = $this->getOrCreateRombel($rombelSaatIni);
        }

        // ===== UPSERT: cari berdasarkan NIPD dulu, fallback ke NISN =====
        $siswa = null;
        if (!empty($nipd)) {
            $siswa = AdminSiswa::where('nipd', $nipd)->first();
        }
        if (!$siswa && !empty($this->str($row, 'nisn'))) {
            $siswa = AdminSiswa::where('nisn', $this->str($row, 'nisn'))->first();
        }
        if (!$siswa) {
            $siswa = new AdminSiswa();
        }

        $siswa->fill([
            'nama'                      => $nama,
            'nipd'                      => $this->str($row, 'nipd'),
            'jk'                        => $this->str($row, 'jk'),
            'nisn'                      => $this->str($row, 'nisn'),
            'tempat_lahir'              => $this->str($row, 'tempat_lahir'),
            'tanggal_lahir'             => $this->date($row, 'tanggal_lahir'),
            'nik'                       => $this->str($row, 'nik'),
            'agama'                     => $this->str($row, 'agama'),
            'alamat'                    => $this->str($row, 'alamat'),
            'rt'                        => $this->str($row, 'rt'),
            'rw'                        => $this->str($row, 'rw'),
            'dusun'                     => $this->str($row, 'dusun'),
            'kelurahan'                 => $this->str($row, 'kelurahan'),
            'kecamatan'                 => $this->str($row, 'kecamatan'),
            'kode_pos'                  => $this->str($row, 'kode_pos'),
            'jenis_tinggal'             => $this->str($row, 'jenis_tinggal'),
            'alat_transportasi'         => $this->str($row, 'alat_transportasi'),
            'telepon'                   => $this->str($row, 'telepon'),
            'hp'                        => $this->str($row, 'hp'),
            'e-mail'                    => $this->str($row, 'email'),
            'skhun'                     => $this->str($row, 'skhun'),
            'penerima_kps'              => $this->str($row, 'penerima_kps'),
            'no_kps'                    => $this->str($row, 'no_kps'),
            'nama_ayah'                 => $this->str($row, 'nama_ayah'),
            'tahun_lahir_ayah'          => $this->year($row, 'tahun_lahir_ayah'),
            'jenjang_pendidikan_ayah'   => $this->str($row, 'jenjang_pendidikan_ayah'),
            'pekerjaan_ayah'            => $this->str($row, 'pekerjaan_ayah'),
            'penghasilan_ayah'          => $this->str($row, 'penghasilan_ayah'),
            'nik_ayah'                  => $this->str($row, 'nik_ayah'),
            'nama_ibu'                  => $this->str($row, 'nama_ibu'),
            'tahun_lahir_ibu'           => $this->year($row, 'tahun_lahir_ibu'),
            'jenjang_pendidikan_ibu'    => $this->str($row, 'jenjang_pendidikan_ibu'),
            'pekerjaan_ibu'             => $this->str($row, 'pekerjaan_ibu'),
            'penghasilan_ibu'           => $this->str($row, 'penghasilan_ibu'),
            'nik_ibu'                   => $this->str($row, 'nik_ibu'),
            'nama_wali'                 => $this->str($row, 'nama_wali'),
            'tahun_lahir_wali'          => $this->year($row, 'tahun_lahir_wali'),
            'jenjang_pendidikan_wali'   => $this->str($row, 'jenjang_pendidikan_wali'),
            'pekerjaan_wali'            => $this->str($row, 'pekerjaan_wali'),
            'penghasilan_wali'          => $this->str($row, 'penghasilan_wali'),
            'nik_wali'                  => $this->str($row, 'nik_wali'),
            'rombel_saat_ini'           => $rombelSaatIni,
            'rombel_id'                 => $rombelId,   // ← relasi FK ke tabel rombel
            'no_peserta_ujian_nasional' => $this->str($row, 'no_peserta_ujian_nasional'),
            'no_seri_ijazah'            => $this->str($row, 'no_seri_ijazah'),
            'penerima_kip'              => $this->bool($row, 'penerima_kip'),
            'nomor_kip'                 => $this->str($row, 'nomor_kip'),
            'nama_di_kip'               => $this->str($row, 'nama_di_kip'),
            'nomor_kks'                 => $this->str($row, 'nomor_kks'),
            'no_registrasi_akta_lahir'  => $this->str($row, 'no_registrasi_akta_lahir'),
            'bank'                      => $this->str($row, 'bank'),
            'nomor_rekening_bank'       => $this->str($row, 'nomor_rekening_bank'),
            'rekening_atas_nama'        => $this->str($row, 'rekening_atas_nama'),
            'layak_pip'                 => $this->bool($row, 'layak_pip'),
            'alasan_layak_pip'          => $this->str($row, 'alasan_layak_pip'),
            'kebutuhan_khusus'          => $this->str($row, 'kebutuhan_khusus'),
            'sekolah_asal'              => $this->str($row, 'sekolah_asal'),
            'anak_ke_berapa'            => $this->int($row, 'anak_ke_berapa', 1, 20)
                                            ?? $this->int($row, 'anak_ke-berapa', 1, 20),
            'lintang'                   => $this->decimal($row, 'lintang'),
            'bujur'                     => $this->decimal($row, 'bujur'),
            'no_kk'                     => $this->str($row, 'no_kk'),
            'berat_badan'               => $this->int($row, 'berat_badan', 1, 300),
            'tinggi_badan'              => $this->int($row, 'tinggi_badan', 1, 300),
            'lingkar_kepala'            => $this->int($row, 'lingkar_kepala', 1, 100),
            'jml_saudara'               => $this->int($row, 'jml_saudara', 0, 30),
            'jarak_rumah'               => $this->int($row, 'jarak_rumah', 0, 99999),
            'password'                  => Hash::make($passwordSource),
        ]);

        return $siswa;
    }
}
