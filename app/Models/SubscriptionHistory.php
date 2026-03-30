<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_copytrading_id',
        'user_id',
        'copytrading_id',
        'from_status',
        'to_status',
        'action',
        'allocation_amount',
        'payload',
    ];

    protected $casts = [
        'allocation_amount' => 'decimal:2',
        'payload' => 'array',
    ];

    public function subscription()
    {
        return $this->belongsTo(CopySubscription::class, 'user_copytrading_id');
    }
}
