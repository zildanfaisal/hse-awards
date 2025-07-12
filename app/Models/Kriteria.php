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
        'tahun',
        'periode_id',
    ];

    public function subKriterias()
    {
        return $this->hasMany(Subkriteria::class);
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
}
