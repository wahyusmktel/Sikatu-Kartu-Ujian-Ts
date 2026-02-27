<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class AdminAuth extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable;

    // Nama tabel yang sesuai di database
    protected $table = 'user_admin';

    // Kolom-kolom yang dapat diisi secara mass-assignment
    protected $fillable = [
        'id',
        'nama',
        'username',
        'password',
        'email',
        'status',
        'created_by',
        'updated_by'
    ];

    // Karena Anda menggunakan UUID, Anda perlu menonaktifkan incrementing untuk kolom ID
    public $incrementing = false;
    protected $keyType = 'string';

    // Ingat untuk men-hash password sebelum menyimpannya
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}