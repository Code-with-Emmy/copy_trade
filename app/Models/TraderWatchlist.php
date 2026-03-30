<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraderWatchlist extends Model
{
    use HasFactory;

    protected $table = 'watchlists';

    protected $fillable = [
        'user_id',
        'copytrading_id',
    ];

    public function trader()
    {
        return $this->belongsTo(Trader::class, 'copytrading_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
