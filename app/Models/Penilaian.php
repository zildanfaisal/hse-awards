<?php

namespace App\Models;

use App\Models\Proyek;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\Periode;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $fillable = [
        'proyek_id',
        'kriteria_id',
        'sub_kriteria_id',
    ];

    public function proyek()
    {
        return $this->belongsTo(Proyek::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }

    public function subKriteria()
    {
        return $this->belongsTo(SubKriteria::class);
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
}
