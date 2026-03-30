<?php

namespace App\Services\Payments\Drivers;

use App\Models\User;
use App\Services\Payments\Contracts\PaymentGatewayInterface;

class NullGateway implements PaymentGatewayInterface
{
    public function key(): string
    {
        return 'manual';
    }

    public function initiateDeposit(User $user, float $amount, array $meta = []): array
    {
        return [
            'gateway' => $this->key(),
            'status' => 'pending',
            'reference' => 'MANUAL-' . strtoupper(uniqid()),
            'checkout_url' => null,
            'message' => 'Manual gateway configured. An admin can reconcile this deposit later.',
            'meta' => $meta,
        ];
    }

    public function verify(string $reference, array $payload = []): array
    {
        return [
            'gateway' => $this->key(),
            'status' => 'pending',
            'reference' => $reference,
            'message' => 'Manual deposits require admin reconciliation.',
            'payload' => $payload,
        ];
    }
}
