<?php

namespace Database\Factories;

use App\Models\Trader;
use App\Models\TraderMetric;
use Illuminate\Database\Eloquent\Factories\Factory;

class TraderMetricFactory extends Factory
{
    protected $model = TraderMetric::class;

    public function definition(): array
    {
        return [
            'copytrading_id' => Trader::factory(),
            'monthly_roi' => $this->faker->randomFloat(2, 4, 18),
            'yearly_roi' => $this->faker->randomFloat(2, 22, 140),
            'max_drawdown' => $this->faker->randomFloat(2, 3, 22),
            'aum' => $this->faker->randomFloat(2, 25000, 2500000),
            'followers_count' => $this->faker->numberBetween(120, 6200),
            'copiers_count' => $this->faker->numberBetween(5, 280),
            'winning_months' => $this->faker->numberBetween(6, 11),
            'losing_months' => $this->faker->numberBetween(1, 5),
            'consistency_score' => $this->faker->numberBetween(58, 96),
            'volatility_score' => $this->faker->numberBetween(22, 84),
            'confidence_score' => $this->faker->numberBetween(60, 98),
            'capital_preservation_score' => $this->faker->numberBetween(42, 95),
            'risk_score' => $this->faker->numberBetween(12, 72),
            'trending_score' => $this->faker->numberBetween(20, 96),
            'view_count' => $this->faker->numberBetween(50, 12000),
            'copied_trades_count' => $this->faker->numberBetween(12, 1200),
            'avg_trade_duration_hours' => $this->faker->numberBetween(4, 168),
            'profit_factor' => $this->faker->randomFloat(2, 1.1, 3.2),
            'sharpe_ratio' => $this->faker->randomFloat(2, 0.4, 2.4),
            'avg_monthly_profit' => $this->faker->randomFloat(2, 200, 20000),
            'recommended_investor_profile' => $this->faker->randomElement(['Capital Preservation', 'Balanced Growth', 'Growth Seeker']),
        ];
    }
}
