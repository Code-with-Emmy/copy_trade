<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraderMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'copytrading_id',
        'monthly_roi',
        'yearly_roi',
        'max_drawdown',
        'aum',
        'followers_count',
        'copiers_count',
        'winning_months',
        'losing_months',
        'consistency_score',
        'volatility_score',
        'confidence_score',
        'capital_preservation_score',
        'risk_score',
        'trending_score',
        'view_count',
        'copied_trades_count',
        'avg_trade_duration_hours',
        'profit_factor',
        'sharpe_ratio',
        'avg_monthly_profit',
        'recommended_investor_profile',
    ];

    protected $casts = [
        'monthly_roi' => 'decimal:2',
        'yearly_roi' => 'decimal:2',
        'max_drawdown' => 'decimal:2',
        'aum' => 'decimal:2',
        'profit_factor' => 'decimal:2',
        'sharpe_ratio' => 'decimal:2',
        'avg_monthly_profit' => 'decimal:2',
    ];

    public function trader()
    {
        return $this->belongsTo(Trader::class, 'copytrading_id');
    }
}
