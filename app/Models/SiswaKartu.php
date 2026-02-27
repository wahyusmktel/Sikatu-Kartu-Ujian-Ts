<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class SiswaKartu extends Model
{
    use HasFactory;

    // Mengatur nama tabel jika berbeda dengan nama model
    protected $table = 'aktivasi_kartu';

    // Otomatis mengatur kolom "id" menjadi UUID
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'tgl_download_kartu'
    ];

    // Relasi ke tabel kartu_ujian
    public function kartuUjian()
    {
        return $this->belongsTo(KartuUjian::class, 'id_kartu');
    }

    // Relasi ke tabel data_ujian
    public function ujian()
    {
        return $this->belongsTo(AdminUjian::class, 'id_ujian');
    }

    // Relasi ke tabel siswa
    public function siswa()
    {
        return $this->belongsTo(AdminSiswa::class, 'id_siswa');
    }
}
