<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class UserCbt extends Model
{
    use HasFactory;

    // Jika Anda menggunakan UUID, Anda perlu mengatur $incrementing menjadi false dan $keyType menjadi string
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_cbt';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'address',
        'course1',
        'course2',
        'course3',
        'course4',
        'course5',
        'course6',
        'course7',
        'course8',
        'course9',
        'course10',
        'course11',
        'course12',
        'course13',
        'course14',
        'course15',
        'id_kartu_ujian',
        'id_siswa',
        'id_ujian'
    ];

    public function kartuUjian()
    {
        return $this->belongsTo(KartuUjian::class, 'id_kartu_ujian');
    }

    public function siswa()
    {
        return $this->belongsTo(AdminSiswa::class, 'id_siswa');
    }

    public function dataUjian()
    {
        return $this->belongsTo(AdminUjian::class, 'id_ujian');
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
