<?php

namespace Tests\Unit\Services;

use App\Services\Payments\Drivers\NullGateway;
use App\Services\Payments\Drivers\PaystackGateway;
use App\Services\Payments\Drivers\StripeGateway;
use App\Services\Payments\PaymentGatewayManager;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PaymentGatewayManagerTest extends TestCase
{
    public function test_it_returns_expected_gateway_driver(): void
    {
        $manager = new PaymentGatewayManager();

        $this->assertInstanceOf(PaystackGateway::class, $manager->gateway('paystack'));
        $this->assertInstanceOf(StripeGateway::class, $manager->gateway('stripe'));
        $this->assertInstanceOf(NullGateway::class, $manager->gateway('manual'));
    }

    public function test_it_rejects_unknown_gateway_drivers(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new PaymentGatewayManager())->gateway('unknown-driver');
    }
}
