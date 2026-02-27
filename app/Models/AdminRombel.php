<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class AdminRombel extends Model
{
    use HasFactory;

    // Jika Anda menggunakan UUID, Anda perlu mengatur $incrementing menjadi false dan $keyType menjadi string
    public $incrementing = false;
    protected $keyType = 'string';

    // Definisikan nama tabel. Jika tidak didefinisikan, Laravel akan menggunakan default yaitu "admin_rombels".
    protected $table = 'rombel';

    // Kolom-kolom yang bisa diisi secara mass-assignment
    protected $fillable = [
        'id',
        'nama_rombel',
        'tingkat_rombel',
        'wali_kelas',
        'status'
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

    public function mapelCbt()
    {
        return $this->hasMany(AdminMapelCbt::class, 'id_rombel');
    }

    public function siswa()
    {
        return $this->hasMany(\App\Models\AdminSiswa::class, 'rombel_id');
    }

}
