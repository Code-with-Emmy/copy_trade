<?php

namespace App\Policies;

use App\Models\CopySubscription;
use App\Models\User;

class CopySubscriptionPolicy
{
    public function view(User $user, CopySubscription $subscription): bool
    {
        return (int) $subscription->user === (int) $user->getKey();
    }

    public function update(User $user, CopySubscription $subscription): bool
    {
        return (int) $subscription->user === (int) $user->getKey();
    }

    public function delete(User $user, CopySubscription $subscription): bool
    {
        return (int) $subscription->user === (int) $user->getKey();
    }
}
