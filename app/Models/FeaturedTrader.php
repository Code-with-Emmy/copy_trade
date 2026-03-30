<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeaturedTrader extends Model
{
    use HasFactory;

    protected $fillable = [
        'copytrading_id',
        'sort_order',
        'is_active',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function trader()
    {
        return $this->belongsTo(Trader::class, 'copytrading_id');
    }
}
