<?php

namespace App\Services\Payments\Drivers;

use App\Models\User;
use App\Services\Payments\Contracts\PaymentGatewayInterface;

class PaystackGateway implements PaymentGatewayInterface
{
    public function key(): string
    {
        return 'paystack';
    }

    public function initiateDeposit(User $user, float $amount, array $meta = []): array
    {
        return [
            'gateway' => $this->key(),
            'status' => 'pending',
            'reference' => 'PSTK-' . strtoupper(uniqid()),
            'checkout_url' => route('payment'),
            'message' => 'Paystack architecture prepared. Existing payment flow can plug into this reference.',
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
