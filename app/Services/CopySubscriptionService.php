<?php

namespace App\Services;

use App\Models\CopySubscription;
use App\Models\SubscriptionHistory;
use App\Models\Trader;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CopySubscriptionService
{
    private WalletService $walletService;
    private NotificationService $notificationService;

    public function __construct(WalletService $walletService, NotificationService $notificationService)
    {
        $this->walletService = $walletService;
        $this->notificationService = $notificationService;
    }

    public function subscribe(User $user, Trader $trader, array $payload): CopySubscription
    {
        return DB::transaction(function () use ($user, $trader, $payload) {
            $amount = (float) $payload['amount'];
            $feeRate = (float) ($payload['fee_rate'] ?? $trader->management_fee_percent ?? 0);
            $feeAmount = round(($amount * $feeRate) / 100, 2);

            $walletTransaction = $this->walletService->debit($user, $amount, 'copy_subscription', [
                'copytrading_id' => $trader->getKey(),
                'fee_amount' => $feeAmount,
                'net_amount' => $amount - $feeAmount,
                'meta' => [
                    'trader' => $trader->name,
                    'mode' => 'subscription_start',
                ],
            ]);

            /** @var CopySubscription $subscription */
            $subscription = CopySubscription::query()->create([
                'cptrading' => $trader->getKey(),
                'user' => $user->getKey(),
                'price' => $amount,
                'allocation_amount' => $amount,
                'current_balance' => $amount - $feeAmount,
                'active' => 'yes',
                'status' => 'active',
                'name' => $trader->name,
                'tag' => $trader->tag,
                'type' => $trader->type ?? 'copy',
                'started_at' => now(),
                'last_profit' => now(),
                'total_profit' => 0,
                'total_trades' => 0,
                'winning_trades' => 0,
                'profit_percentage' => 0,
                'copy_ratio' => (float) ($payload['copy_ratio'] ?? 1),
                'risk_preference' => $payload['risk_preference'] ?? 'balanced',
                'max_drawdown_guard' => $payload['max_drawdown_guard'] ?? $trader->max_drawdown ?: 0,
                'fee_rate' => $feeRate,
                'platform_fee_amount' => $feeAmount,
                'subscription_reference' => 'SUB-' . Str::upper(Str::random(10)),
                'meta' => [
                    'wallet_transaction_id' => $walletTransaction->getKey(),
                ],
            ]);

            $this->recordHistory($subscription, null, 'active', 'subscribed');

            $trader->increment('followers');

            $this->notificationService->createUserNotification(
                $user->getKey(),
                'Copy subscription started',
                "You are now copying {$trader->name} with {$user->currency}{$amount}.",
                'copy_subscription',
                $subscription->getKey(),
                CopySubscription::class
            );

            return $subscription->fresh(['trader']);
        });
    }

    public function pause(CopySubscription $subscription): CopySubscription
    {
        return DB::transaction(function () use ($subscription) {
            $from = $subscription->status;
            $subscription->forceFill([
                'status' => 'paused',
                'active' => 'no',
                'paused_at' => now(),
            ])->save();

            $this->recordHistory($subscription, $from, 'paused', 'paused');

            $this->notificationService->createUserNotification(
                $subscription->user,
                'Copy subscription paused',
                "Your copy subscription for {$subscription->name} has been paused.",
                'copy_subscription',
                $subscription->getKey(),
                CopySubscription::class
            );

            return $subscription;
        });
    }

    public function resume(CopySubscription $subscription): CopySubscription
    {
        return DB::transaction(function () use ($subscription) {
            $from = $subscription->status;
            $subscription->forceFill([
                'status' => 'active',
                'active' => 'yes',
                'paused_at' => null,
            ])->save();

            $this->recordHistory($subscription, $from, 'active', 'resumed');

            $this->notificationService->createUserNotification(
                $subscription->user,
                'Copy subscription resumed',
                "Your copy subscription for {$subscription->name} is active again.",
                'copy_subscription',
                $subscription->getKey(),
                CopySubscription::class
            );

            return $subscription;
        });
    }

    public function update(CopySubscription $subscription, array $payload): CopySubscription
    {
        return DB::transaction(function () use ($subscription, $payload) {
            $subscription->fill([
                'allocation_amount' => $payload['amount'] ?? $subscription->allocation_amount,
                'copy_ratio' => $payload['copy_ratio'] ?? $subscription->copy_ratio,
                'risk_preference' => $payload['risk_preference'] ?? $subscription->risk_preference,
                'max_drawdown_guard' => $payload['max_drawdown_guard'] ?? $subscription->max_drawdown_guard,
                'fee_rate' => $payload['fee_rate'] ?? $subscription->fee_rate,
            ])->save();

            $this->recordHistory($subscription, $subscription->status, $subscription->status, 'updated', [
                'amount' => $subscription->allocation_amount,
                'copy_ratio' => $subscription->copy_ratio,
                'risk_preference' => $subscription->risk_preference,
            ]);

            return $subscription;
        });
    }

    public function stop(CopySubscription $subscription): CopySubscription
    {
        return DB::transaction(function () use ($subscription) {
            $from = $subscription->status;
            $creditAmount = max(0, (float) $subscription->current_balance);

            $walletTransaction = $this->walletService->credit(
                $subscription->investor,
                $creditAmount,
                'copy_profit',
                [
                    'copytrading_id' => $subscription->cptrading,
                    'user_copytrading_id' => $subscription->getKey(),
                    'meta' => ['mode' => 'subscription_stop'],
                ]
            );

            $subscription->forceFill([
                'status' => 'stopped',
                'active' => 'no',
                'stopped_at' => now(),
                'realized_profit' => $subscription->realized_profit + max(0, $subscription->total_profit),
                'unrealized_profit' => 0,
                'meta' => array_merge($subscription->meta ?? [], [
                    'closing_transaction_id' => $walletTransaction->getKey(),
                ]),
            ])->save();

            $this->recordHistory($subscription, $from, 'stopped', 'stopped', [
                'credited_amount' => $creditAmount,
            ]);

            if ($subscription->trader && $subscription->trader->followers > 0) {
                $subscription->trader->decrement('followers');
            }

            $this->notificationService->createUserNotification(
                $subscription->user,
                'Copy subscription stopped',
                "Your {$subscription->name} copy subscription has been closed and funds returned to your wallet.",
                'copy_subscription',
                $subscription->getKey(),
                CopySubscription::class
            );

            return $subscription;
        });
    }

    private function recordHistory(
        CopySubscription $subscription,
        ?string $fromStatus,
        string $toStatus,
        string $action,
        array $payload = []
    ): void {
        SubscriptionHistory::query()->create([
            'user_copytrading_id' => $subscription->getKey(),
            'user_id' => $subscription->user,
            'copytrading_id' => $subscription->cptrading,
            'from_status' => $fromStatus,
            'to_status' => $toStatus,
            'action' => $action,
            'allocation_amount' => $subscription->allocation_amount ?: $subscription->price,
            'payload' => $payload,
        ]);
    }
}
