<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RankingBatch extends Model
{
    protected $fillable = [
        'nama_sesi',
        'calculated_at',
        'user_id',
        'catatan',
        'calculation_details',
        'assessment_details',
    ];

    protected $casts = [
        'calculated_at' => 'datetime',
    ];

    public function details()
    {
        return $this->hasMany(RankingDetail::class, 'ranking_batch_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
