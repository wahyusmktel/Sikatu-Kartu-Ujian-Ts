<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class AdminMapelCbt extends Model
{
    use HasFactory;

    protected $table = 'mapel_cbt';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [          // Tentukan kolom yang dapat diisi
        'id', 'category', 'format', 'shortname', 'fullname', 'status', 'id_ujian'
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

    // Hubungan dengan tabel data_ujian
    public function dataUjian()
    {
        return $this->belongsTo(AdminUjian::class, 'id_ujian', 'id');
    }
    
    public function rombel()
    {
        return $this->belongsTo(AdminRombel::class, 'id_rombel');
    }
}
