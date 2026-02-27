<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class AdminUjian extends Model
{
    use HasFactory;
    
    // Mengatur nama tabel jika berbeda dengan nama model
    protected $table = 'data_ujian';

    // Mengatur primary key jika bukan 'id'
    protected $primaryKey = 'id';

    // Menentukan tipe data primary key jika bukan integer
    protected $keyType = 'string';

    // Mengatur bahwa tabel tidak memiliki auto incrementing
    public $incrementing = false;

    // Kolom-kolom yang dapat diisi massal
    protected $fillable = [
        'id', 'nama_ujian', 'kode_ujian', 'tahun_pelajaran', 'semester', 'link_ujian', 
        'tgl_mulai', 'tgl_akhir', 'status'
    ];

    // Hook saat model sedang disimpan
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Uuid::uuid4();
            }
        });
    }
}