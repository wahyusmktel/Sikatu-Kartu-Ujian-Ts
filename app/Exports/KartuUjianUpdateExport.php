<?php

namespace App\Exports;

use App\Models\KartuUjian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class KartuUjianUpdateExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles, WithTitle
{
    public function title(): string
    {
        return 'Update Username & Password';
    }

    public function collection()
    {
        $data = KartuUjian::with(['ujian', 'siswa'])
            ->whereHas('ujian', function ($query) {
                $query->where('status', true);
            })
            ->orderBy('created_at')
            ->get();

        $no = 1;
        return $data->map(function ($kartu) use (&$no) {
            return [
                $no++,
                optional($kartu->ujian)->nama_ujian . ' - ' . optional($kartu->ujian)->semester . ' TP ' . optional($kartu->ujian)->tahun_pelajaran,
                optional($kartu->siswa)->nama,
                optional($kartu->siswa)->rombel_saat_ini ?? '-',
                $kartu->username_ujian,
                $kartu->password_ujian,
                $kartu->id, // ID untuk keperluan import (jangan diubah)
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Ujian',
            'Nama Siswa',
            'Kelas',
            'Username Ujian *',
            'Password Ujian *',
            'ID (Jangan Diubah)',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 45,
            'C' => 30,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 40,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();

        // Border semua cell
        $sheet->getStyle("A1:G{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
            'font' => ['name' => 'Arial Narrow'],
        ]);

        // Header style
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => ['bold' => true, 'name' => 'Arial Narrow'],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1E5799'],
            ],
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'name' => 'Arial Narrow'],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Kolom username & password — warna hijau muda (editable)
        $sheet->getStyle("E2:F{$lastRow}")->applyFromArray([
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E8F5E9'],
            ],
        ]);

        // Kolom ID — warna abu (read-only)
        $sheet->getStyle("G2:G{$lastRow}")->applyFromArray([
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'EEEEEE'],
            ],
            'font' => ['color' => ['rgb' => '999999']],
        ]);

        // Alignment
        $sheet->getStyle("A2:A{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B2:D{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("E2:G{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }
}
