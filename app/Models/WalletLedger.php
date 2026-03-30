<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletLedger extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_account_id',
        'user_id',
        'transaction_id',
        'entry_type',
        'direction',
        'amount',
        'balance_before',
        'balance_after',
        'reference',
        'meta',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'meta' => 'array',
    ];

    public function wallet()
    {
        return $this->belongsTo(WalletAccount::class, 'wallet_account_id');
    }

    public function transaction()
    {
        return $this->belongsTo(PlatformTransaction::class, 'transaction_id');
    }
}
