<?php

namespace App\Imports;

use App\Models\AdminSiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class SiswaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new AdminSiswa([
            'nama' => $row['nama'],
            'nipd' => $row['nipd'],
            'jk' => $row['jk'],
            'nisn' => $row['nisn'],
            'tempat_lahir' => $row['tempat_lahir'],
            'tanggal_lahir' => $row['tanggal_lahir'],
            'nik' => $row['nik'],
            'agama' => $row['agama'],
            'alamat' => $row['alamat'],
            'rt' => $row['rt'],
            'rw' => $row['rw'],
            'dusun' => $row['dusun'],
            'kelurahan' => $row['kelurahan'],
            'kecamatan' => $row['kecamatan'],
            'kode_pos' => $row['kode_pos'],
            'jenis_tinggal' => $row['jenis_tinggal'],
            'alat_transportasi' => $row['alat_transportasi'],
            'telepon' => $row['telepon'],
            'hp' => $row['hp'],
            'e-mail' => $row['email'],
            'skhun' => $row['skhun'],
            'penerima_kps' => $row['penerima_kps'],
            'no_kps' => $row['no_kps'],
            'nama_ayah' => $row['nama_ayah'],
            'tahun_lahir_ayah' => $row['tahun_lahir_ayah'],
            'jenjang_pendidikan_ayah' => $row['jenjang_pendidikan_ayah'],
            'pekerjaan_ayah' => $row['pekerjaan_ayah'],
            'penghasilan_ayah' => $row['penghasilan_ayah'],
            'nik_ayah' => $row['nik_ayah'],
            'nama_ibu' => $row['nama_ibu'],
            'tahun_lahir_ibu' => $row['tahun_lahir_ibu'],
            'jenjang_pendidikan_ibu' => $row['jenjang_pendidikan_ibu'],
            'pekerjaan_ibu' => $row['pekerjaan_ibu'],
            'penghasilan_ibu' => $row['penghasilan_ibu'],
            'nik_ibu' => $row['nik_ibu'],
            'nama_wali' => $row['nama_wali'],
            'tahun_lahir_wali' => $row['tahun_lahir_wali'],
            'jenjang_pendidikan_wali' => $row['jenjang_pendidikan_wali'],
            'pekerjaan_wali' => $row['pekerjaan_wali'],
            'penghasilan_wali' => $row['penghasilan_wali'],
            'nik_wali' => $row['nik_wali'],
            'rombel_saat_ini' => $row['rombel_saat_ini'],
            'no_peserta_ujian_nasional' => $row['no_peserta_ujian_nasional'],
            'no_seri_ijazah' => $row['no_seri_ijazah'],
            'penerima_kip' => $row['penerima_kip'] === 'Ya' ? true : false,
            'nomor_kip' => $row['nomor_kip'],
            'nama_di_kip' => $row['nama_di_kip'],
            'nomor_kks' => $row['nomor_kks'],
            'no_registrasi_akta_lahir' => $row['no_registrasi_akta_lahir'],
            'bank' => $row['bank'],
            'nomor_rekening_bank' => $row['nomor_rekening_bank'],
            'rekening_atas_nama' => $row['rekening_atas_nama'],
            'layak_pip' => $row['layak_pip'] === 'Ya' ? true : false,
            'alasan_layak_pip' => $row['alasan_layak_pip'],
            'kebutuhan_khusus' => $row['kebutuhan_khusus'],
            'sekolah_asal' => $row['sekolah_asal'],
            'anak_ke-berapa' => $row['anak_ke_berapa'],
            'lintang' => $row['lintang'],
            'bujur' => $row['bujur'],
            'no_kk' => $row['no_kk'],
            'berat_badan' => $row['berat_badan'],
            'tinggi_badan' => $row['tinggi_badan'],
            'lingkar_kepala' => $row['lingkar_kepala'],
            'jml_saudara' => $row['jml_saudara'],
            'jarak_rumah' => $row['jarak_rumah'],
            'password' => Hash::make($row['nipd']),
        ]);
        
    }
}
