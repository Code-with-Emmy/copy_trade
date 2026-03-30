<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaderboardSnapshot extends Model
{
    use HasFactory;

    protected $fillable = [
        'copytrading_id',
        'board',
        'rank',
        'score',
        'snapshot_date',
        'meta',
    ];

    protected $casts = [
        'score' => 'decimal:4',
        'snapshot_date' => 'date',
        'meta' => 'array',
    ];

    public function trader()
    {
        return $this->belongsTo(Trader::class, 'copytrading_id');
    }
}
