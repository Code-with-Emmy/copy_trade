<?php

namespace Database\Seeders;

use App\Models\Wdmethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        if (!Schema::hasTable('wdmethods')) {
            return;
        }

        $methods = [
            [
                'name' => 'Bitcoin',
                'type' => 'deposit',
                'status' => 'enabled',
                'minimum' => 100,
                'maximum' => 5000000,
                'fixed_fee' => 0,
                'percentage_fee' => 1.5,
                'image' => 'crypto/btc.png',
            ],
            [
                'name' => 'Ethereum',
                'type' => 'deposit',
                'status' => 'enabled',
                'minimum' => 100,
                'maximum' => 5000000,
                'fixed_fee' => 0,
                'percentage_fee' => 1.5,
                'image' => 'crypto/eth.png',
            ],
            [
                'name' => 'Tether (USDT)',
                'type' => 'both',
                'status' => 'enabled',
                'minimum' => 50,
                'maximum' => 5000000,
                'fixed_fee' => 2,
                'percentage_fee' => 0,
                'image' => 'crypto/usdt.png',
            ],
            [
                'name' => 'USD Coin (USDC)',
                'type' => 'both',
                'status' => 'enabled',
                'minimum' => 50,
                'maximum' => 5000000,
                'fixed_fee' => 2,
                'percentage_fee' => 0,
                'image' => 'crypto/usdc.png',
            ],
            [
                'name' => 'Binance Coin',
                'type' => 'deposit',
                'status' => 'enabled',
                'minimum' => 50,
                'maximum' => 5000000,
                'fixed_fee' => 0,
                'percentage_fee' => 1.25,
                'image' => 'crypto/bnb.png',
            ],
            [
                'name' => 'Litecoin',
                'type' => 'deposit',
                'status' => 'enabled',
                'minimum' => 50,
                'maximum' => 3000000,
                'fixed_fee' => 0,
                'percentage_fee' => 1.25,
                'image' => 'crypto/ltc.png',
            ],
            [
                'name' => 'Solana',
                'type' => 'deposit',
                'status' => 'enabled',
                'minimum' => 50,
                'maximum' => 3000000,
                'fixed_fee' => 0,
                'percentage_fee' => 1.25,
                'image' => 'crypto/sol.png',
            ],
            [
                'name' => 'Dogecoin',
                'type' => 'deposit',
                'status' => 'enabled',
                'minimum' => 25,
                'maximum' => 2000000,
                'fixed_fee' => 0,
                'percentage_fee' => 1.75,
                'image' => 'crypto/doge.png',
            ],
            [
                'name' => 'Bank Transfer',
                'type' => 'withdrawal',
                'status' => 'enabled',
                'minimum' => 100,
                'maximum' => 10000000,
                'fixed_fee' => 10,
                'percentage_fee' => 0,
                'image' => 'payments/bank-transfer.png',
            ],
            [
                'name' => 'Wire Transfer',
                'type' => 'withdrawal',
                'status' => 'enabled',
                'minimum' => 500,
                'maximum' => 10000000,
                'fixed_fee' => 25,
                'percentage_fee' => 0,
                'image' => 'payments/wire-transfer.png',
            ],
            [
                'name' => 'Perfect Money',
                'type' => 'both',
                'status' => 'enabled',
                'minimum' => 50,
                'maximum' => 5000000,
                'fixed_fee' => 5,
                'percentage_fee' => 0,
                'image' => 'payments/perfect-money.png',
            ],
            [
                'name' => 'Payeer',
                'type' => 'both',
                'status' => 'enabled',
                'minimum' => 50,
                'maximum' => 5000000,
                'fixed_fee' => 5,
                'percentage_fee' => 0,
                'image' => 'payments/payeer.png',
            ],
        ];

        foreach ($methods as $method) {
            Wdmethod::query()->updateOrCreate(
                ['name' => $method['name']],
                $method
            );
        }
    }
}
