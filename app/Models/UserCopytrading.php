<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCopytrading extends Model
{
    use HasFactory;

    protected $table = 'user_copytradings';

    protected $fillable = [
        'user',
        'trader',
        'cptrading',
        'amount',
        'price',
        'active',
        'status',
        'name',
        'tag',
        'type',
        'total_profit',
        'profit_percentage',
        'current_balance',
        'total_trades',
        'winning_trades',
        'started_at',
        'last_profit',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user');
    }

    public function investor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user');
    }

    public function expert(): BelongsTo
    {
        return $this->belongsTo(Trader::class, 'cptrading');
    }

    public function trader(): BelongsTo
    {
        return $this->belongsTo(Trader::class, 'cptrading');
    }
}
