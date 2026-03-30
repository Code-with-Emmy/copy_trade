<?php

namespace App\Policies;

use App\Models\Trader;
use App\Models\User;

class TraderPolicy
{
    public function view(?User $user, Trader $trader): bool
    {
        return $trader->status === 'active';
    }

    public function subscribe(User $user, Trader $trader): bool
    {
        return $trader->status === 'active';
    }
}
