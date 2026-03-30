<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Trader extends Copytrading
{
    use HasFactory;

    protected $table = 'copytradings';

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

    protected static function booted(): void
    {
        static::saving(function (Trader $trader) {
            if (blank($trader->slug) && filled($trader->name)) {
                $trader->slug = Str::slug($trader->name . '-' . ($trader->id ?: Str::random(4)));
            }
        });
    }

    public function metric()
    {
        return $this->hasOne(TraderMetric::class, 'copytrading_id');
    }

    public function performanceHistory()
    {
        return $this->hasMany(TraderPerformanceHistory::class, 'copytrading_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(CopySubscription::class, 'cptrading');
    }

    public function activeSubscriptions()
    {
        return $this->subscriptions()->where('status', 'active');
    }

    public function copiedTrades()
    {
        return $this->hasMany(CopiedTrade::class, 'copytrading_id');
    }

    public function featuredPlacement()
    {
        return $this->hasOne(FeaturedTrader::class, 'copytrading_id');
    }

    public function leaderboardSnapshots()
    {
        return $this->hasMany(LeaderboardSnapshot::class, 'copytrading_id');
    }

    public function watchlists()
    {
        return $this->hasMany(TraderWatchlist::class, 'copytrading_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    public function scopeVerified(Builder $query): Builder
    {
        return $query->where('verification_status', 'verified');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function displayName(): Attribute
    {
        return Attribute::get(fn () => $this->name);
    }
}
