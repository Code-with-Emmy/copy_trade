<?php

namespace Database\Factories;

use App\Models\CopySubscription;
use App\Models\Trader;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CopySubscriptionFactory extends Factory
{
    protected $model = CopySubscription::class;

    public function definition(): array
    {
        $allocation = $this->faker->randomFloat(2, 250, 8000);
        $profit = $this->faker->randomFloat(2, -250, 1800);

        return [
            'cptrading' => Trader::factory(),
            'user' => User::factory(),
            'price' => $allocation,
            'active' => 'yes',
            'status' => 'active',
            'name' => $this->faker->name(),
            'tag' => $this->faker->randomElement(['Macro', 'Swing', 'Scalp']),
            'type' => 'copy',
            'started_at' => now()->subDays($this->faker->numberBetween(2, 160)),
            'last_profit' => now()->subHours($this->faker->numberBetween(2, 72)),
            'total_profit' => $profit,
            'current_balance' => $allocation + $profit,
            'total_trades' => $this->faker->numberBetween(6, 180),
            'winning_trades' => $this->faker->numberBetween(4, 120),
            'profit_percentage' => $this->faker->randomFloat(2, -12, 42),
            'allocation_amount' => $allocation,
            'allocated_profit' => $profit,
            'realized_profit' => max(0, $profit / 2),
            'unrealized_profit' => $profit / 2,
            'max_drawdown_guard' => $this->faker->randomFloat(2, 5, 20),
            'copy_ratio' => $this->faker->randomFloat(2, 0.5, 2),
            'risk_preference' => $this->faker->randomElement(['conservative', 'balanced', 'aggressive']),
            'fee_rate' => $this->faker->randomFloat(2, 0, 3),
            'platform_fee_amount' => $this->faker->randomFloat(2, 0, 80),
            'subscription_reference' => 'SUB-' . Str::upper(Str::random(10)),
        ];
    }
}
