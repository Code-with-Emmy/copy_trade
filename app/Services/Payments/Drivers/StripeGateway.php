<?php

namespace App\Services\Payments\Drivers;

use App\Models\User;
use App\Services\Payments\Contracts\PaymentGatewayInterface;

class StripeGateway implements PaymentGatewayInterface
{
    public function key(): string
    {
        return 'stripe';
    }

    public function initiateDeposit(User $user, float $amount, array $meta = []): array
    {
        return [
            'gateway' => $this->key(),
            'status' => 'pending',
            'reference' => 'STRP-' . strtoupper(uniqid()),
            'checkout_url' => route('payment'),
            'message' => 'Stripe gateway abstraction is ready for a checkout/session implementation.',
            'meta' => $meta,
        ];
    }

    public function verify(string $reference, array $payload = []): array
    {
        return [
            'gateway' => $this->key(),
            'status' => 'processing',
            'reference' => $reference,
            'payload' => $payload,
        ];
    }
}
