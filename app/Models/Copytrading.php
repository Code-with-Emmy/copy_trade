<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Copytrading extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'photo',
        'rating',
        'followers',
        'equity',
        'total_profit',
        'status',
        'description',
        'bio',
        'win_rate',
        'total_trades',
        'price',
        'tag',
        'type',
        'verification_status',
        'verified_at',
        'strategy_type',
        'risk_level',
        'trading_style',
        'preferred_instruments',
        'markets_traded',
        'monthly_roi',
        'yearly_roi',
        'max_drawdown',
        'aum',
        'consistency_score',
        'volatility_score',
        'confidence_score',
        'capital_preservation_score',
        'recommended_investor_profile',
        'minimum_allocation',
        'maximum_allocation',
        'max_allocation_percent',
        'management_fee_percent',
        'performance_fee_percent',
        'is_featured',
        'is_ranked',
        'badges',
    ];

    protected $casts = [
        'rating' => 'integer',
        'followers' => 'integer',
        'equity' => 'decimal:2',
        'total_profit' => 'decimal:2',
        'win_rate' => 'integer',
        'total_trades' => 'integer',
        'price' => 'decimal:2',
        'verified_at' => 'datetime',
        'monthly_roi' => 'decimal:2',
        'yearly_roi' => 'decimal:2',
        'max_drawdown' => 'decimal:2',
        'aum' => 'decimal:2',
        'minimum_allocation' => 'decimal:2',
        'maximum_allocation' => 'decimal:2',
        'max_allocation_percent' => 'decimal:2',
        'management_fee_percent' => 'decimal:2',
        'performance_fee_percent' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_ranked' => 'boolean',
        'badges' => 'array',
    ];

    /**
     * Get users who are copying this trader
     */
    public function copiers()
    {
        return $this->hasMany(UserCopytrading::class, 'cptrading', 'id');
    }

    /**
     * Get active copiers only
     */
    public function activeCopiers()
    {
        return $this->hasMany(UserCopytrading::class, 'cptrading', 'id')
                    ->where('active', 'yes');
    }

    public function metric()
    {
        return $this->hasOne(TraderMetric::class, 'copytrading_id', 'id');
    }

    public function performanceHistory()
    {
        return $this->hasMany(TraderPerformanceHistory::class, 'copytrading_id', 'id');
    }

    public function watchlists()
    {
        return $this->hasMany(TraderWatchlist::class, 'copytrading_id', 'id');
    }

    public function featuredPlacement()
    {
        return $this->hasOne(FeaturedTrader::class, 'copytrading_id', 'id');
    }

    public function leaderboardSnapshots()
    {
        return $this->hasMany(LeaderboardSnapshot::class, 'copytrading_id', 'id');
    }

    /**
     * Get the success rate attribute
     */
    public function getSuccessRateAttribute()
    {
        return $this->win_rate ?? 80;
    }

    /**
     * Get formatted profit rate
     */
    public function getFormattedProfitRateAttribute()
    {
        return number_format($this->equity, 1) . '%';
    }

    public function getIsVerifiedAttribute()
    {
        return $this->verification_status === 'verified';
    }
}
