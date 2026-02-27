<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class SiswaAuth extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;

    protected $table = 'siswa';

    protected $keyType = 'string';
    public $incrementing = false;


}
