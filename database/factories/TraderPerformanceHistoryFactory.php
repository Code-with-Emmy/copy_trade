<?php

namespace Database\Factories;

use App\Models\Trader;
use App\Models\TraderPerformanceHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

class TraderPerformanceHistoryFactory extends Factory
{
    protected $model = TraderPerformanceHistory::class;

    public function definition(): array
    {
        return [
            'copytrading_id' => Trader::factory(),
            'period_date' => now()->startOfMonth()->subMonths($this->faker->numberBetween(0, 11)),
            'period_type' => 'monthly',
            'return_percentage' => $this->faker->randomFloat(2, -4, 18),
            'equity_value' => $this->faker->randomFloat(2, 10000, 2500000),
            'drawdown_percentage' => $this->faker->randomFloat(2, 2, 25),
            'volatility_percentage' => $this->faker->randomFloat(2, 1, 22),
            'wins' => $this->faker->numberBetween(4, 20),
            'losses' => $this->faker->numberBetween(1, 8),
            'trades_count' => $this->faker->numberBetween(8, 40),
            'meta' => ['source' => 'factory'],
        ];
    }
}
