<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'currency',
        'available_balance',
        'reserved_balance',
        'lifetime_deposits',
        'lifetime_withdrawals',
        'lifetime_fees',
        'status',
        'last_reconciled_at',
    ];

    protected $casts = [
        'available_balance' => 'decimal:2',
        'reserved_balance' => 'decimal:2',
        'lifetime_deposits' => 'decimal:2',
        'lifetime_withdrawals' => 'decimal:2',
        'lifetime_fees' => 'decimal:2',
        'last_reconciled_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ledgers()
    {
        return $this->hasMany(WalletLedger::class);
    }

    public function transactions()
    {
        return $this->hasMany(PlatformTransaction::class);
    }
}
