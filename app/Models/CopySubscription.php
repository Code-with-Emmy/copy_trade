<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CopySubscription extends UserCopytrading
{
    use HasFactory;

    protected $table = 'user_copytradings';

    protected $fillable = [
        'cptrading',
        'user',
        'price',
        'active',
        'status',
        'name',
        'tag',
        'type',
        'started_at',
        'last_profit',
        'total_profit',
        'current_balance',
        'total_trades',
        'winning_trades',
        'profit_percentage',
        'allocation_amount',
        'allocated_profit',
        'realized_profit',
        'unrealized_profit',
        'max_drawdown_guard',
        'copy_ratio',
        'risk_preference',
        'fee_rate',
        'platform_fee_amount',
        'subscription_reference',
        'paused_at',
        'stopped_at',
        'last_synced_at',
        'meta',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'total_profit' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'profit_percentage' => 'decimal:2',
        'allocation_amount' => 'decimal:2',
        'allocated_profit' => 'decimal:2',
        'realized_profit' => 'decimal:2',
        'unrealized_profit' => 'decimal:2',
        'max_drawdown_guard' => 'decimal:2',
        'copy_ratio' => 'decimal:2',
        'fee_rate' => 'decimal:2',
        'platform_fee_amount' => 'decimal:2',
        'started_at' => 'datetime',
        'last_profit' => 'datetime',
        'paused_at' => 'datetime',
        'stopped_at' => 'datetime',
        'last_synced_at' => 'datetime',
        'meta' => 'array',
    ];

    public function trader(): BelongsTo
    {
        return $this->belongsTo(Trader::class, 'cptrading');
    }

    public function investor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user');
    }

    public function history(): HasMany
    {
        return $this->hasMany(SubscriptionHistory::class, 'user_copytrading_id');
    }

    public function copiedTrades(): HasMany
    {
        return $this->hasMany(CopiedTrade::class, 'user_copytrading_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(PlatformTransaction::class, 'user_copytrading_id');
    }

    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user', $userId);
    }

    public function scopeActiveStatus(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }
}
