<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraderPerformanceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'copytrading_id',
        'period_date',
        'period_type',
        'return_percentage',
        'equity_value',
        'drawdown_percentage',
        'volatility_percentage',
        'wins',
        'losses',
        'trades_count',
        'meta',
    ];

    protected $casts = [
        'period_date' => 'date',
        'return_percentage' => 'decimal:2',
        'equity_value' => 'decimal:2',
        'drawdown_percentage' => 'decimal:2',
        'volatility_percentage' => 'decimal:2',
        'meta' => 'array',
    ];

    public function trader()
    {
        return $this->belongsTo(Trader::class, 'copytrading_id');
    }
}
