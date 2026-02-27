<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class AdminSettings extends Model
{
    use HasFactory;

    protected $table = 'settings';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'nama_sekolah', 'nama_kepsek', 'no_hp_sekolah', 'email_sekolah', 'logo_sekolah', 'npsn', 'alamat_sekolah', 'status'
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
