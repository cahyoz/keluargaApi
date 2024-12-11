<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keluarga extends Model
{
    use HasFactory;

    protected $table = 'keluarga';

    protected $fillable = [
        'Nama',
        'Kelamin',
        'orangTuaId',
    ];
}