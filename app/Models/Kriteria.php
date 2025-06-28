<?php

namespace App\Models;

use App\Models\Subkriteria;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $fillable = [
        'kode_kriteria',
        'nama_kriteria',
        'keterangan_kriteria',
        'tipe_kriteria',
        'bobot',
    ];

    public function subKriterias()
    {
        return $this->hasMany(Subkriteria::class);
    }
}
