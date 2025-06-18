<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RankingDetail extends Model
{
    protected $fillable = [
        'ranking_batch_id',
        'proyek_id',
        'final_maut_score',
        'rank',
    ];

    public function rankingBatch()
    {
        return $this->belongsTo(RankingBatch::class, 'ranking_batch_id');
    }

    public function proyek()
    {
        return $this->belongsTo(Proyek::class, 'proyek_id');
    }
}
