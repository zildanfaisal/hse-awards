<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    protected $fillable = [
        'kode_proyek',
        'nama_proyek',
        'manajer_proyek',
        'jenis_proyek',
        'lokasi_proyek',
    ];
}
