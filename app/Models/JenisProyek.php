<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisProyek extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_jenis',
        'nama_jenis',
    ];
} 