<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CopiedTrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_copytrading_id',
        'copytrading_id',
        'user_id',
        'symbol',
        'market',
        'direction',
        'entry_price',
        'exit_price',
        'quantity',
        'profit_loss',
        'profit_loss_percentage',
        'status',
        'opened_at',
        'closed_at',
        'meta',
    ];

    protected $casts = [
        'entry_price' => 'decimal:8',
        'exit_price' => 'decimal:8',
        'quantity' => 'decimal:8',
        'profit_loss' => 'decimal:2',
        'profit_loss_percentage' => 'decimal:2',
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
        'meta' => 'array',
    ];

    public function subscription()
    {
        return $this->belongsTo(CopySubscription::class, 'user_copytrading_id');
    }

    public function trader()
    {
        return $this->belongsTo(Trader::class, 'copytrading_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
