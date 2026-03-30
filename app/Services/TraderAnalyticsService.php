<?php

namespace App\Services;

use App\Models\CopiedTrade;
use App\Models\CopySubscription;
use App\Models\Trader;
use App\Models\TraderMetric;
use App\Models\TraderPerformanceHistory;
use Illuminate\Support\Collection;

class TraderAnalyticsService
{
    public function hydrateTrader(Trader $trader): Trader
    {
        $metric = $trader->metric ?: $this->syncMetric($trader);

        $trader->setRelation('metric', $metric);

        return $trader;
    }

    public function syncMetric(Trader $trader): TraderMetric
    {
        $activeSubscriptions = CopySubscription::query()
            ->where('cptrading', $trader->getKey())
            ->where('status', 'active')
            ->get();

        $copiedTrades = CopiedTrade::query()
            ->where('copytrading_id', $trader->getKey())
            ->get();

        $metric = TraderMetric::query()->firstOrNew([
            'copytrading_id' => $trader->getKey(),
        ]);

        $metric->fill([
            'monthly_roi' => (float) ($trader->monthly_roi ?? $trader->equity ?? 0),
            'yearly_roi' => (float) ($trader->yearly_roi ?? $trader->total_profit ?? 0),
            'max_drawdown' => (float) ($trader->max_drawdown ?? 0),
            'aum' => (float) ($trader->aum ?: $activeSubscriptions->sum('current_balance')),
            'followers_count' => (int) ($trader->followers ?? 0),
            'copiers_count' => $activeSubscriptions->count(),
            'winning_months' => max(0, (int) floor(((float) $trader->win_rate) / 10)),
            'losing_months' => max(0, 12 - (int) floor(((float) $trader->win_rate) / 10)),
            'consistency_score' => $this->scoreConsistency($trader),
            'volatility_score' => $this->scoreVolatility($trader),
            'confidence_score' => $this->scoreConfidence($trader),
            'capital_preservation_score' => $this->scoreCapitalPreservation($trader),
            'risk_score' => $this->calculateRiskScore($trader),
            'trending_score' => $this->calculateTrendingScore($trader),
            'view_count' => (int) ($metric->view_count ?? 0),
            'copied_trades_count' => $copiedTrades->count(),
            'avg_trade_duration_hours' => (int) round($copiedTrades->avg(function (CopiedTrade $trade) {
                if (!$trade->opened_at || !$trade->closed_at) {
                    return 0;
                }

                return $trade->opened_at->diffInHours($trade->closed_at);
            }) ?: 0),
            'profit_factor' => $this->calculateProfitFactor($copiedTrades),
            'sharpe_ratio' => $this->calculateSharpeLikeRatio($trader),
            'avg_monthly_profit' => (float) (($trader->monthly_roi ?? 0) / 100) * max(1, (float) ($trader->aum ?? $activeSubscriptions->sum('price'))),
            'recommended_investor_profile' => $this->recommendedInvestorProfile($trader),
        ]);

        $metric->save();

        $trader->forceFill([
            'monthly_roi' => $metric->monthly_roi,
            'yearly_roi' => $metric->yearly_roi,
            'max_drawdown' => $metric->max_drawdown,
            'aum' => $metric->aum,
            'consistency_score' => $metric->consistency_score,
            'volatility_score' => $metric->volatility_score,
            'confidence_score' => $metric->confidence_score,
            'capital_preservation_score' => $metric->capital_preservation_score,
            'risk_level' => $this->resolveRiskLabel($metric->risk_score),
            'recommended_investor_profile' => $metric->recommended_investor_profile,
        ])->save();

        return $metric;
    }

    public function performanceSummary(Trader $trader): array
    {
        $metric = $trader->metric ?: $this->syncMetric($trader);
        $history = $this->history($trader);

        return [
            'trader' => $trader,
            'metric' => $metric,
            'risk_label' => $this->resolveRiskLabel($metric->risk_score),
            'performance' => [
                'monthly_roi' => (float) $metric->monthly_roi,
                'yearly_roi' => (float) $metric->yearly_roi,
                'max_drawdown' => (float) $metric->max_drawdown,
                'aum' => (float) $metric->aum,
                'followers' => (int) $metric->followers_count,
                'win_rate' => (float) $trader->win_rate,
                'avg_trade_duration_hours' => (int) $metric->avg_trade_duration_hours,
                'profit_factor' => (float) $metric->profit_factor,
                'sharpe_ratio' => (float) $metric->sharpe_ratio,
            ],
            'scores' => [
                'risk' => (int) $metric->risk_score,
                'consistency' => (int) $metric->consistency_score,
                'volatility' => (int) $metric->volatility_score,
                'confidence' => (int) $metric->confidence_score,
                'capital_preservation' => (int) $metric->capital_preservation_score,
            ],
            'charts' => [
                'returns' => $history->pluck('return_percentage'),
                'equity_curve' => $history->pluck('equity_value'),
                'drawdown' => $history->pluck('drawdown_percentage'),
                'labels' => $history->map(fn (TraderPerformanceHistory $item) => $item->period_date->format('M Y')),
            ],
            'monthly_table' => $history->map(fn (TraderPerformanceHistory $item) => [
                'period' => $item->period_date->format('M Y'),
                'return_percentage' => (float) $item->return_percentage,
                'drawdown_percentage' => (float) $item->drawdown_percentage,
                'wins' => (int) $item->wins,
                'losses' => (int) $item->losses,
                'trades_count' => (int) $item->trades_count,
            ]),
            'recent_trades' => CopiedTrade::query()
                ->where('copytrading_id', $trader->getKey())
                ->latest('opened_at')
                ->limit(8)
                ->get(),
        ];
    }

    public function history(Trader $trader, int $months = 12): Collection
    {
        $history = $trader->performanceHistory()
            ->orderBy('period_date')
            ->limit($months)
            ->get();

        if ($history->isNotEmpty()) {
            return $history;
        }

        $baseReturn = (float) ($trader->monthly_roi ?: $trader->equity ?: 6);
        $baseEquity = max(1000, (float) ($trader->aum ?: 25000));

        return collect(range(11, 0))->map(function (int $offset) use ($trader, $baseReturn, $baseEquity) {
            return new TraderPerformanceHistory([
                'copytrading_id' => $trader->getKey(),
                'period_date' => now()->startOfMonth()->subMonths($offset),
                'period_type' => 'monthly',
                'return_percentage' => round(max(-6, $baseReturn - 4 + ($offset % 5) * 1.35), 2),
                'equity_value' => round($baseEquity + ((11 - $offset) * ($baseEquity * max(0.01, $baseReturn / 100))), 2),
                'drawdown_percentage' => round(max(1.2, min(30, (float) ($trader->max_drawdown ?: 6) + (($offset % 3) - 1))), 2),
                'volatility_percentage' => round(max(2, min(35, (float) ($trader->volatility_score ?: 12) / 2)), 2),
                'wins' => 8 + ($offset % 4),
                'losses' => 2 + ($offset % 3),
                'trades_count' => 10 + ($offset % 7),
            ]);
        });
    }

    public function calculateRiskScore(Trader $trader): int
    {
        $drawdownComponent = min(45, (float) ($trader->max_drawdown ?: 0) * 1.6);
        $volatilityComponent = min(35, max(0, (float) ($trader->volatility_score ?: 0)));
        $winRatePenalty = max(0, 25 - ((float) ($trader->win_rate ?: 0) / 4));
        $capitalPreservationBoost = max(0, 15 - ((float) ($trader->capital_preservation_score ?: 0) / 10));

        return (int) round(min(100, $drawdownComponent + $volatilityComponent + $winRatePenalty + $capitalPreservationBoost));
    }

    public function resolveRiskLabel(int $score): string
    {
        return match (true) {
            $score <= 24 => 'low',
            $score <= 49 => 'medium',
            $score <= 74 => 'high',
            default => 'very high',
        };
    }

    public function recommendedInvestorProfile(Trader $trader): string
    {
        return match ($this->resolveRiskLabel($this->calculateRiskScore($trader))) {
            'low' => 'Capital Preservation',
            'medium' => 'Balanced Growth',
            'high' => 'Growth Seeker',
            default => 'Aggressive Opportunist',
        };
    }

    public function calculateTrendingScore(Trader $trader): int
    {
        return (int) round(min(
            100,
            (($trader->followers ?? 0) / 100)
            + (($trader->monthly_roi ?? 0) * 3)
            + (($trader->win_rate ?? 0) / 3)
            + (($trader->is_featured ?? false) ? 10 : 0)
        ));
    }

    private function scoreConsistency(Trader $trader): int
    {
        return (int) round(min(100, max(0, (($trader->win_rate ?? 0) * 0.55) + (100 - (($trader->max_drawdown ?? 0) * 1.3)))));
    }

    private function scoreVolatility(Trader $trader): int
    {
        return (int) round(min(100, max(0, (($trader->max_drawdown ?? 0) * 2.1) + max(0, 80 - (($trader->win_rate ?? 0) * 0.5)))));
    }

    private function scoreConfidence(Trader $trader): int
    {
        return (int) round(min(100, max(0, (($trader->win_rate ?? 0) * 0.7) + (($trader->followers ?? 0) / 50) + (($trader->rating ?? 0) * 5))));
    }

    private function scoreCapitalPreservation(Trader $trader): int
    {
        return (int) round(min(100, max(0, 100 - (($trader->max_drawdown ?? 0) * 2.5))));
    }

    private function calculateProfitFactor(Collection $copiedTrades): float
    {
        $grossProfit = (float) $copiedTrades->where('profit_loss', '>', 0)->sum('profit_loss');
        $grossLoss = abs((float) $copiedTrades->where('profit_loss', '<', 0)->sum('profit_loss'));

        if ($grossLoss <= 0.0) {
            return $grossProfit > 0 ? 2.5 : 0.0;
        }

        return round($grossProfit / $grossLoss, 2);
    }

    private function calculateSharpeLikeRatio(Trader $trader): float
    {
        $monthlyRoi = (float) ($trader->monthly_roi ?: 0);
        $drawdown = max(1, (float) ($trader->max_drawdown ?: 1));

        return round($monthlyRoi / $drawdown, 2);
    }
}
