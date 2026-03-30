<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;

class UserPlan extends Model
{
    use HasFactory;
    protected $table = 'user_plans';

    protected $fillable = [
        'plan',
        'user',
        'amount',
        'activate',
        'inv_duration',
        'expire_date',
        'activated_at',
        'last_growth',
        'assets',
        'type',
        'leverage',
        'profit_earned',
        'active',
        'symbol'
    ];

    protected $casts = [
        'amount' => 'decimal:8',
        'activated_at' => 'datetime',
        'last_growth' => 'datetime',
        'expire_date' => 'datetime',
    ];

    public function dplan()
    {
        return $this->belongsTo(Plans::class, 'plan', 'id');
    }

    public function duser()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan', 'id');
    }

    public function payouts(): HasMany
    {
        return $this->hasMany(PlanPayout::class, 'user_plan_id', 'id');
    }

    public function getUserIdAttribute(): ?int
    {
        return isset($this->attributes['user']) ? (int) $this->attributes['user'] : null;
    }

    public function getPlanIdAttribute(): ?int
    {
        return isset($this->attributes['plan']) ? (int) $this->attributes['plan'] : null;
    }

    public function getInvestedAmountAttribute(): float
    {
        return (float) ($this->attributes['amount'] ?? 0);
    }

    public function getTotalProfitAttribute(): float
    {
        return (float) ($this->attributes['profit_earned'] ?? 0);
    }

    public function getCurrentValueAttribute(): float
    {
        return $this->invested_amount + $this->total_profit;
    }

    public function getExpectedProfitAttribute(): float
    {
        if (!$this->relationLoaded('plan') || !$this->plan) {
            return 0.0;
        }

        return max(0.0, (float) $this->plan->calculateExpectedReturn($this->invested_amount) - $this->invested_amount);
    }

    public function getExpiresAtAttribute(): ?Carbon
    {
        return $this->expire_date;
    }

    public function getStartDateAttribute(): ?Carbon
    {
        return $this->activated_at;
    }

    public function getEndDateAttribute(): ?Carbon
    {
        return $this->expire_date;
    }

    public function getLastRoiDateAttribute(): ?Carbon
    {
        if (!Schema::hasTable('plan_payouts')) {
            return null;
        }

        return optional($this->payouts->sortByDesc('processed_at')->first())->processed_at;
    }

    public function getTotalPaidAmountAttribute(): float
    {
        if (Schema::hasTable('plan_payouts')) {
            return (float) $this->payouts->sum('amount');
        }

        return (float) ($this->attributes['profit_earned'] ?? 0);
    }

    public function getCancelledAtAttribute(): ?Carbon
    {
        if (isset($this->attributes['cancelled_at'])) {
            return Carbon::parse($this->attributes['cancelled_at']);
        }

        return $this->status === 'cancelled' ? $this->updated_at : null;
    }

    public function getCompletedAtAttribute(): ?Carbon
    {
        return $this->status === 'completed' ? $this->expire_date : null;
    }

    public function getStatusAttribute(): string
    {
        $active = $this->attributes['active'] ?? null;
        $isActive = in_array($active, [1, '1', true, 'yes', 'active'], true);

        if (!$isActive) {
            return $this->activated_at ? 'cancelled' : 'pending';
        }

        if ($this->expire_date instanceof Carbon && $this->expire_date->isPast()) {
            return 'completed';
        }

        return $this->activated_at ? 'active' : 'pending';
    }

    public function getRoiPercentageAttribute(): float
    {
        if ($this->invested_amount <= 0) {
            return 0.0;
        }

        return round(($this->total_profit / $this->invested_amount) * 100, 2);
    }

    public function getProgressPercentage(): int
    {
        if (!$this->activated_at || !$this->expire_date) {
            return 0;
        }

        $total = max(1, $this->activated_at->diffInSeconds($this->expire_date, false));
        $elapsed = $this->activated_at->diffInSeconds(now(), false);

        return (int) max(0, min(100, round(($elapsed / $total) * 100)));
    }
}
