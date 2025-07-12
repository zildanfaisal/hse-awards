<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proyek extends Model
{
    use HasFactory;

    protected $fillable = [
        'periode_id',
        'kode_proyek',
        'nama_proyek',
        'manajer_proyek_id',
        'jenis_proyek_id',
        'lokasi_proyek',
        'tahun',
    ];

    /**
     * Mendefinisikan relasi one-to-many ke model Penilaian.
     * Sebuah proyek dapat memiliki banyak penilaian.
     */
    public function penilaians()
    {
        return $this->hasMany(Penilaian::class);
    }

    public function manajerProyek()
    {
        return $this->belongsTo(ManajerProyek::class, 'manajer_proyek_id');
    }

    public function jenisProyek()
    {
        return $this->belongsTo(JenisProyek::class, 'jenis_proyek_id');
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
}
