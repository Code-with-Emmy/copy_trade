<?php

namespace App\Services;

use App\Models\PlatformTransaction;
use App\Models\User;
use App\Services\Payments\PaymentGatewayManager;

class DepositService
{
    private PaymentGatewayManager $paymentGatewayManager;
    private WalletService $walletService;

    public function __construct(PaymentGatewayManager $paymentGatewayManager, WalletService $walletService)
    {
        $this->paymentGatewayManager = $paymentGatewayManager;
        $this->walletService = $walletService;
    }

    public function initiate(User $user, float $amount, string $gateway, array $meta = []): array
    {
        $response = $this->paymentGatewayManager->gateway($gateway)->initiateDeposit($user, $amount, $meta);

        $transaction = PlatformTransaction::query()->create([
            'user_id' => $user->getKey(),
            'wallet_account_id' => $this->walletService->ensureWallet($user)->getKey(),
            'type' => 'deposit',
            'status' => $response['status'] ?? 'pending',
            'amount' => $amount,
            'fee_amount' => 0,
            'net_amount' => $amount,
            'currency' => $user->currency ?: 'USD',
            'gateway' => $response['gateway'] ?? $gateway,
            'reference' => $response['reference'] ?? null,
            'payment_reference' => $response['reference'] ?? null,
            'meta' => $response['meta'] ?? $meta,
        ]);

        return [
            'transaction' => $transaction,
            'gateway' => $response,
        ];
    }
}
