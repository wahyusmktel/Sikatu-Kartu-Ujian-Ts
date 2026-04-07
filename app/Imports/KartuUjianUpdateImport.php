<?php

namespace App\Imports;

use App\Models\KartuUjian;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KartuUjianUpdateImport implements ToModel, WithHeadingRow
{
    private int $updated = 0;
    private int $skipped = 0;

    public function model(array $row)
    {
        // Kolom heading dari Excel (sudah ter-normalize ke lowercase+underscore oleh library):
        // no, nama_ujian, nama_siswa, kelas, username_ujian_, password_ujian_, id_jangan_diubah

        // Ambil ID dari kolom terakhir
        $id = trim((string)($row['id_jangan_diubah'] ?? ''));

        if (empty($id)) {
            $this->skipped++;
            return null;
        }

        $kartu = KartuUjian::find($id);

        if (!$kartu) {
            $this->skipped++;
            return null;
        }

        $username = trim((string)($row['username_ujian_'] ?? $row['username_ujian'] ?? ''));
        $password = trim((string)($row['password_ujian_'] ?? $row['password_ujian'] ?? ''));

        if (empty($username) || empty($password)) {
            $this->skipped++;
            return null;
        }

        $kartu->update([
            'username_ujian' => $username,
            'password_ujian' => $password,
        ]);

        $this->updated++;

        return null; // kita sudah update manual, tidak perlu return model
    }

    public function getUpdated(): int
    {
        return $this->updated;
    }

    public function getSkipped(): int
    {
        return $this->skipped;
    }
}
