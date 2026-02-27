<?php

namespace App\Exports;

use App\Models\KartuUjian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SiswaAktivasiExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles
{
    public function collection()
    {
        $data = KartuUjian::with(['ujian', 'siswa', 'aktivasiKartu'])
            ->whereHas('ujian', function($query) {
                $query->where('status', true);
            })
            ->whereHas('aktivasiKartu', function($query) {
                $query->where('status_aktivasi', true);
            })
            ->get();

        $no = 1; // Untuk nomor urut
        return $data->map(function ($kartu) use (&$no) {
            return [
                $no++,
                $kartu->siswa->nama,
                $kartu->siswa->rombel_saat_ini,
                $kartu->aktivasiKartu ? ($kartu->aktivasiKartu->status_aktivasi ? 'Sudah Aktivasi' : 'Belum Aktivasi') : 'Belum Aktivasi'
            ];
        });
    }

    public function headings(): array
    {
        return ['No', 'Nama', 'Rombel Saat Ini', 'Status Aktivasi'];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,  // Untuk kolom No
            'B' => 30, // Ubah sesuai kebutuhan
            'C' => 30,
            'D' => 20
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'font' => [
                'name' => 'Arial Narrow',
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ]
        ];
        
        // Gaya untuk header (Bold, tinggi, warna gray muda)
        $headerStyle = [
            'font' => [
                'bold' => true,
                'name' => 'Arial Narrow'
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'D3D3D3'
                ]
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ]
        ];

        // Set gaya untuk semua sel
        $sheet->getStyle('A1:D' . $sheet->getHighestRow())->applyFromArray($styleArray);

        // Khusus untuk kolom nama, set alignment ke left (kecuali header)
        $sheet->getStyle('B2:B' . $sheet->getHighestRow())->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        // Set gaya untuk header
        $sheet->getStyle('A1:D1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(25); // Set tinggi header
    }
}
