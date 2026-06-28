<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Schema;

class Plan extends Model
{
    use HasFactory;
    use SoftDeletes {
        bootSoftDeletes as protected bootSoftDeletesTrait;
        initializeSoftDeletes as protected initializeSoftDeletesTrait;
    }

    protected $table = 'plans';

    protected $fillable = [
        'name', 'slug', 'description', 'price',
        'min_price', 'max_price', 'min_reinvest', 'max_reinvest',
        'min_return', 'max_return', 'bonus_percentage',
        'duration', 'duration_type', 'payout_interval',
        'return_type', 'profit_calculation',
        'allow_compounding', 'compounding_percentage',
        'featured', 'badge_text', 'color_scheme',
        'active', 'sort_order', 'features',
    ];

    protected $casts = [
        'min_price'         => 'decimal:8',
        'max_price'         => 'decimal:8',
        'min_return'        => 'decimal:2',
        'max_return'        => 'decimal:2',
        'bonus_percentage'  => 'decimal:2',
        'allow_compounding' => 'boolean',
        'featured'          => 'boolean',
        'active'            => 'boolean',
        'features'          => 'array',
    ];

    // ── Schema column cache ───────────────────────────────────────────────────
    // We hardcode the table name here to avoid calling `new static()` inside
    // initializeSoftDeletes(), which would cause infinite recursion → OOM.

    private static array $colCache = [];

    private static function columnExists(string $column): bool
    {
        if (!array_key_exists($column, self::$colCache)) {
            self::$colCache[$column] = Schema::hasColumn('plans', $column);
        }
        return self::$colCache[$column];
    }

    // ── SoftDeletes: only boot if the column actually exists ─────────────────

    protected static function bootSoftDeletes(): void
    {
        if (self::columnExists('deleted_at')) {
            static::bootSoftDeletesTrait();
        }
    }

    public function initializeSoftDeletes(): void
    {
        if (self::columnExists('deleted_at')) {
            $this->initializeSoftDeletesTrait();
        }
    }

    // ── Relationships ─────────────────────────────────────────────────────────

    public function userPlans(): HasMany
    {
        return $this->hasMany(UserPlan::class, 'plan');
    }

    public function planFeatures(): HasMany
    {
        return $this->hasMany(PlanFeature::class);
    }

    public function categories(): BelongsToMany
    {
        if (!Schema::hasTable('plan_plan_category') || !Schema::hasTable('plan_categories')) {
            return $this->belongsToMany(PlanCategory::class, 'plan_plan_category')->whereRaw('1 = 0');
        }
        return $this->belongsToMany(PlanCategory::class, 'plan_plan_category');
    }

    // ── Accessors (read $attributes directly — no Schema calls at runtime) ────

    public function getIsActiveAttribute(): bool
    {
        return (bool) ($this->attributes['active'] ?? true);
    }

    public function getIsFeaturedAttribute(): bool
    {
        return (bool) ($this->attributes['featured'] ?? false);
    }

    public function getRoiPercentageAttribute(): float
    {
        return (float) ($this->attributes['roi_percentage']
            ?? $this->attributes['returns']
            ?? 0);
    }

    public function getMinAmountAttribute(): float
    {
        return (float) ($this->attributes['min_amount']
            ?? $this->attributes['min_price']
            ?? 0);
    }

    public function getMaxAmountAttribute(): float
    {
        return (float) ($this->attributes['max_amount']
            ?? $this->attributes['max_price']
            ?? 0);
    }

    public function getRoiIntervalAttribute(): string
    {
        return (string) ($this->attributes['roi_interval']
            ?? $this->attributes['type']
            ?? 'Standard plan');
    }

    public function getDurationUnitAttribute(): string
    {
        return (string) ($this->attributes['duration_unit']
            ?? $this->attributes['expiration']
            ?? 'days');
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    public function getDurationInDays(): int
    {
        $multiplier = match ($this->attributes['duration_type'] ?? 'days') {
            'weeks'  => 7,
            'months' => 30,
            'years'  => 365,
            default  => 1,
        };
        return (int) ($this->attributes['duration'] ?? 1) * $multiplier;
    }

    public function calculateExpectedReturn(float $amount): float
    {
        $min = (float) ($this->attributes['min_return'] ?? 0);
        $max = (float) ($this->attributes['max_return'] ?? 0);
        $avg = ($min + $max) / 2;

        if (($this->attributes['return_type'] ?? 'percentage') === 'percentage') {
            return $amount * ($avg / 100) + $amount;
        }
        return $amount + (float) ($this->attributes['price'] ?? 0);
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        if (!self::columnExists('active')) {
            return $query;
        }
        return $query->where('active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('plan_category_id', $categoryId);
        });
    }
}
