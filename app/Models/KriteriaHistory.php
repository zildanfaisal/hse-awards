<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'kriteria_id',
        'user_id',
        'field',
        'old_value',
        'new_value',
        'changed_at',
    ];

    protected $casts = [
        'changed_at' => 'datetime',
    ];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 