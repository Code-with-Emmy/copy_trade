<?php

namespace Database\Factories;

use App\Models\CopiedTrade;
use App\Models\CopySubscription;
use App\Models\Trader;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CopiedTradeFactory extends Factory
{
    protected $model = CopiedTrade::class;

    public function definition(): array
    {
        $openedAt = now()->subDays($this->faker->numberBetween(1, 90));
        $profit = $this->faker->randomFloat(2, -180, 420);

        return [
            'user_copytrading_id' => CopySubscription::factory(),
            'copytrading_id' => Trader::factory(),
            'user_id' => User::factory(),
            'symbol' => $this->faker->randomElement(['EURUSD', 'GBPUSD', 'XAUUSD', 'BTCUSD', 'ETHUSD', 'NAS100']),
            'market' => $this->faker->randomElement(['forex', 'crypto', 'indices', 'commodities']),
            'direction' => $this->faker->randomElement(['buy', 'sell']),
            'entry_price' => $this->faker->randomFloat(5, 1, 50000),
            'exit_price' => $this->faker->randomFloat(5, 1, 50000),
            'quantity' => $this->faker->randomFloat(4, 0.1, 10),
            'profit_loss' => $profit,
            'profit_loss_percentage' => $this->faker->randomFloat(2, -8, 15),
            'status' => $this->faker->randomElement(['open', 'closed']),
            'opened_at' => $openedAt,
            'closed_at' => $this->faker->boolean(80) ? (clone $openedAt)->addHours($this->faker->numberBetween(2, 120)) : null,
            'meta' => ['source' => 'factory'],
        ];
    }
}
