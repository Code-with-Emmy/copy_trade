<?php

namespace App\Services\Payments\Contracts;

use App\Models\User;

interface PaymentGatewayInterface
{
    public function key(): string;

    public function initiateDeposit(User $user, float $amount, array $meta = []): array;

    public function verify(string $reference, array $payload = []): array;
}
