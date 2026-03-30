<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatformTransaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'user_id',
        'wallet_account_id',
        'copytrading_id',
        'user_copytrading_id',
        'type',
        'status',
        'amount',
        'fee_amount',
        'net_amount',
        'currency',
        'gateway',
        'reference',
        'payment_reference',
        'provider_reference',
        'meta',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'fee_amount' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'meta' => 'array',
        'processed_at' => 'datetime',
    ];

    public function wallet()
    {
        return $this->belongsTo(WalletAccount::class, 'wallet_account_id');
    }

    public function trader()
    {
        return $this->belongsTo(Trader::class, 'copytrading_id');
    }

    public function subscription()
    {
        return $this->belongsTo(CopySubscription::class, 'user_copytrading_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
