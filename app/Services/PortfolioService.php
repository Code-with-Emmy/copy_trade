<?php

namespace App\Services;

use App\Models\CopySubscription;
use App\Models\User;
use Illuminate\Support\Collection;

class PortfolioService
{
    public function summary(User $user): array
    {
        $subscriptions = CopySubscription::query()
            ->with(['trader.metric', 'copiedTrades'])
            ->forUser($user->getKey())
            ->latest()
            ->get();

        $active = $subscriptions->where('status', 'active');
        $closedTrades = $subscriptions->flatMap->copiedTrades->where('status', 'closed');
        $openTrades = $subscriptions->flatMap->copiedTrades->where('status', 'open');

        $growthSeries = $this->growthSeries($subscriptions);

        return [
            'subscriptions' => $subscriptions,
            'active_subscriptions' => $active,
            'portfolio_value' => round($active->sum('current_balance'), 2),
            'allocated_capital' => round($active->sum('allocation_amount'), 2),
            'realized_pl' => round($subscriptions->sum('realized_profit'), 2),
            'unrealized_pl' => round($subscriptions->sum('unrealized_profit'), 2),
            'profit_by_trader' => $subscriptions->map(fn (CopySubscription $subscription) => [
                'name' => $subscription->name,
                'allocation' => (float) $subscription->allocation_amount,
                'profit' => (float) ($subscription->realized_profit + $subscription->unrealized_profit),
                'status' => $subscription->status,
            ]),
            'allocation_chart' => $active->map(fn (CopySubscription $subscription) => [
                'label' => $subscription->name,
                'value' => (float) $subscription->allocation_amount,
            ]),
            'growth_chart' => $growthSeries,
            'profit_by_month' => $this->profitByMonth($closedTrades),
            'risk_exposure' => $this->riskExposure($active),
            'active_positions' => $openTrades->values(),
            'closed_positions' => $closedTrades->values(),
        ];
    }

    private function growthSeries(Collection $subscriptions): array
    {
        return collect(range(5, 0))->map(function (int $offset) use ($subscriptions) {
            $label = now()->startOfMonth()->subMonths($offset)->format('M');
            $baseValue = $subscriptions->sum('allocation_amount') ?: $subscriptions->sum('price');
            $growth = $subscriptions->sum('profit_percentage') / max(1, $subscriptions->count());

            return [
                'label' => $label,
                'value' => round($baseValue * (1 + (($growth - $offset) / 100)), 2),
            ];
        })->all();
    }

    private function profitByMonth(Collection $closedTrades): array
    {
        if ($closedTrades->isEmpty()) {
            return collect(range(5, 0))->map(fn (int $offset) => [
                'label' => now()->startOfMonth()->subMonths($offset)->format('M'),
                'value' => 0,
            ])->all();
        }

        return $closedTrades
            ->groupBy(fn ($trade) => optional($trade->closed_at)->format('M') ?: now()->format('M'))
            ->map(fn (Collection $group, string $label) => [
                'label' => $label,
                'value' => round($group->sum('profit_loss'), 2),
            ])
            ->values()
            ->all();
    }

    private function riskExposure(Collection $activeSubscriptions): array
    {
        return $activeSubscriptions
            ->groupBy(fn (CopySubscription $subscription) => optional($subscription->trader)->risk_level ?: 'medium')
            ->map(fn (Collection $group, string $label) => [
                'label' => ucfirst($label),
                'value' => round($group->sum('allocation_amount'), 2),
            ])
            ->values()
            ->all();
    }
}
