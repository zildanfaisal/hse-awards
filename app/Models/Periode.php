<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $fillable = ['nama_periode', 'is_active'];

    public function proyeks()
    {
        return $this->hasMany(Proyek::class);
    }
    public function kriterias()
    {
        return $this->hasMany(Kriteria::class);
    }
    public function subKriterias()
    {
        return $this->hasMany(SubKriteria::class);
    }
    public function penilaians()
    {
        return $this->hasMany(Penilaian::class);
    }

    public static function getActivePeriode()
    {
        return self::where('is_active', true)->first();
    }
} 