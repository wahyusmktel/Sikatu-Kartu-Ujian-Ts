<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class KartuUjian extends Model
{
    use HasFactory;  // Tambahkan SoftDeletes jika Anda menggunakannya

    protected $table = 'kartu_ujian';

    protected $primaryKey = 'id';

    // Jika Anda menggunakan UUID sebagai primary key
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id_ujian', 'id_siswa', 'username_ujian', 'password_ujian', 'status'];

    // Relasi dengan model lain, jika diperlukan
    public function ujian()
    {
        return $this->belongsTo(AdminUjian::class, 'id_ujian');
    }

    public function siswa()
    {
        return $this->belongsTo(AdminSiswa::class, 'id_siswa');
    }

    public function aktivasiKartu()
    {
        return $this->hasOne(AdminAktivasiKartu::class, 'id_kartu');
    }

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
