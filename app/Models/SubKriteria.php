<?php

namespace App\Models;

use App\Models\Kriteria;
use App\Models\Periode;
use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    protected $fillable = [
        'kriteria_id',
        'nama_sub_kriteria',
        'keterangan_sub_kriteria',
        'nilai_sub_kriteria',
        'kode_sub_kriteria',
        'tahun',
        'periode_id',
    ];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
}
