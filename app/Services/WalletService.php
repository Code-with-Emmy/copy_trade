<?php

namespace App\Services;

use App\Models\PlatformTransaction;
use App\Models\User;
use App\Models\WalletAccount;
use App\Models\WalletLedger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WalletService
{
    public function ensureWallet(User $user): WalletAccount
    {
        return WalletAccount::query()->firstOrCreate(
            ['user_id' => $user->getKey()],
            [
                'currency' => $user->currency ?: 'USD',
                'available_balance' => (float) ($user->account_bal ?? 0),
                'reserved_balance' => 0,
                'lifetime_deposits' => 0,
                'lifetime_withdrawals' => 0,
                'lifetime_fees' => 0,
                'status' => 'active',
            ]
        );
    }

    public function syncLegacyBalance(User $user, ?WalletAccount $wallet = null): WalletAccount
    {
        $wallet ??= $this->ensureWallet($user);

        if ((float) $wallet->available_balance !== (float) $user->account_bal) {
            $wallet->forceFill([
                'available_balance' => (float) $user->account_bal,
                'last_reconciled_at' => now(),
            ])->save();
        }

        $user->forceFill([
            'wallet_balance_synced_at' => now(),
        ])->save();

        return $wallet->fresh();
    }

    public function debit(
        User $user,
        float $amount,
        string $type,
        array $attributes = []
    ): PlatformTransaction {
        return DB::transaction(function () use ($user, $amount, $type, $attributes) {
            $wallet = $this->syncLegacyBalance($user);

            if ((float) $wallet->available_balance < $amount) {
                throw new \RuntimeException('Insufficient wallet balance.');
            }

            $transaction = PlatformTransaction::query()->create(array_merge([
                'user_id' => $user->getKey(),
                'wallet_account_id' => $wallet->getKey(),
                'type' => $type,
                'status' => 'processed',
                'amount' => $amount,
                'fee_amount' => (float) ($attributes['fee_amount'] ?? 0),
                'net_amount' => (float) ($attributes['net_amount'] ?? $amount),
                'currency' => $wallet->currency,
                'gateway' => $attributes['gateway'] ?? 'internal',
                'reference' => $attributes['reference'] ?? Str::upper($type) . '-' . Str::random(10),
                'payment_reference' => $attributes['payment_reference'] ?? null,
                'provider_reference' => $attributes['provider_reference'] ?? null,
                'copytrading_id' => $attributes['copytrading_id'] ?? null,
                'user_copytrading_id' => $attributes['user_copytrading_id'] ?? null,
                'meta' => $attributes['meta'] ?? null,
                'processed_at' => now(),
            ], $attributes));

            $before = (float) $wallet->available_balance;
            $after = round($before - $amount, 2);

            $wallet->forceFill([
                'available_balance' => $after,
                'lifetime_fees' => $wallet->lifetime_fees + ((float) $transaction->fee_amount),
            ])->save();

            $user->forceFill([
                'account_bal' => $after,
                'wallet_balance_synced_at' => now(),
            ])->save();

            WalletLedger::query()->create([
                'wallet_account_id' => $wallet->getKey(),
                'user_id' => $user->getKey(),
                'transaction_id' => $transaction->getKey(),
                'entry_type' => $type,
                'direction' => 'debit',
                'amount' => $amount,
                'balance_before' => $before,
                'balance_after' => $after,
                'reference' => $transaction->reference,
                'meta' => $attributes['meta'] ?? null,
            ]);

            return $transaction;
        });
    }

    public function credit(
        User $user,
        float $amount,
        string $type,
        array $attributes = []
    ): PlatformTransaction {
        return DB::transaction(function () use ($user, $amount, $type, $attributes) {
            $wallet = $this->syncLegacyBalance($user);

            $transaction = PlatformTransaction::query()->create(array_merge([
                'user_id' => $user->getKey(),
                'wallet_account_id' => $wallet->getKey(),
                'type' => $type,
                'status' => 'processed',
                'amount' => $amount,
                'fee_amount' => (float) ($attributes['fee_amount'] ?? 0),
                'net_amount' => (float) ($attributes['net_amount'] ?? $amount),
                'currency' => $wallet->currency,
                'gateway' => $attributes['gateway'] ?? 'internal',
                'reference' => $attributes['reference'] ?? Str::upper($type) . '-' . Str::random(10),
                'payment_reference' => $attributes['payment_reference'] ?? null,
                'provider_reference' => $attributes['provider_reference'] ?? null,
                'copytrading_id' => $attributes['copytrading_id'] ?? null,
                'user_copytrading_id' => $attributes['user_copytrading_id'] ?? null,
                'meta' => $attributes['meta'] ?? null,
                'processed_at' => now(),
            ], $attributes));

            $before = (float) $wallet->available_balance;
            $after = round($before + $amount, 2);

            $wallet->forceFill([
                'available_balance' => $after,
                'lifetime_deposits' => $type === 'deposit' ? $wallet->lifetime_deposits + $amount : $wallet->lifetime_deposits,
                'lifetime_withdrawals' => $type === 'withdrawal' ? $wallet->lifetime_withdrawals + $amount : $wallet->lifetime_withdrawals,
                'lifetime_fees' => $wallet->lifetime_fees + ((float) $transaction->fee_amount),
            ])->save();

            $user->forceFill([
                'account_bal' => $after,
                'wallet_balance_synced_at' => now(),
            ])->save();

            WalletLedger::query()->create([
                'wallet_account_id' => $wallet->getKey(),
                'user_id' => $user->getKey(),
                'transaction_id' => $transaction->getKey(),
                'entry_type' => $type,
                'direction' => 'credit',
                'amount' => $amount,
                'balance_before' => $before,
                'balance_after' => $after,
                'reference' => $transaction->reference,
                'meta' => $attributes['meta'] ?? null,
            ]);

            return $transaction;
        });
    }
}
