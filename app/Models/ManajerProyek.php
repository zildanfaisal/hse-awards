<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManajerProyek extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_manajer',
        'nama_manajer',
    ];
} 