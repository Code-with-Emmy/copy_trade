<?php

namespace Tests\Unit\Services;

use App\Models\Trader;
use App\Services\TraderAnalyticsService;
use PHPUnit\Framework\TestCase;

class TraderAnalyticsServiceTest extends TestCase
{
    public function test_it_resolves_risk_labels_by_score_band(): void
    {
        $service = new TraderAnalyticsService();

        $this->assertSame('low', $service->resolveRiskLabel(10));
        $this->assertSame('medium', $service->resolveRiskLabel(35));
        $this->assertSame('high', $service->resolveRiskLabel(60));
        $this->assertSame('very high', $service->resolveRiskLabel(90));
    }

    public function test_it_scores_low_drawdown_traders_lower_than_high_drawdown_traders(): void
    {
        $service = new TraderAnalyticsService();

        $lowRiskTrader = new Trader([
            'max_drawdown' => 5,
            'volatility_score' => 20,
            'win_rate' => 82,
            'capital_preservation_score' => 88,
        ]);

        $highRiskTrader = new Trader([
            'max_drawdown' => 24,
            'volatility_score' => 75,
            'win_rate' => 54,
            'capital_preservation_score' => 38,
        ]);

        $this->assertLessThan(
            $service->calculateRiskScore($highRiskTrader),
            $service->calculateRiskScore($lowRiskTrader)
        );
    }
}
