<?php

namespace App\Services\Payments;

use App\Services\Payments\Contracts\PaymentGatewayInterface;
use App\Services\Payments\Drivers\NullGateway;
use App\Services\Payments\Drivers\PaystackGateway;
use App\Services\Payments\Drivers\StripeGateway;
use InvalidArgumentException;

class PaymentGatewayManager
{
    public function gateway(?string $driver = null): PaymentGatewayInterface
    {
        return match ($driver ?: config('services.copytrader.default_gateway', 'manual')) {
            'paystack' => new PaystackGateway(),
            'stripe' => new StripeGateway(),
            'manual', 'flutterwave', 'crypto' => new NullGateway(),
            default => throw new InvalidArgumentException("Unsupported payment gateway [{$driver}]."),
        };
    }
}
