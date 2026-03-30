<?php

namespace Database\Factories;

use App\Models\Trader;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TraderFactory extends Factory
{
    protected $model = Trader::class;

    public function definition(): array
    {
        $name = $this->faker->name();
        $monthlyRoi = $this->faker->randomFloat(2, 4.2, 18.5);
        $drawdown = $this->faker->randomFloat(2, 3.1, 22.4);

        return [
            'name' => $name,
            'slug' => Str::slug($name . '-' . $this->faker->unique()->numberBetween(10, 999)),
            'photo' => null,
            'rating' => $this->faker->numberBetween(3, 5),
            'followers' => $this->faker->numberBetween(120, 6200),
            'equity' => $monthlyRoi,
            'total_profit' => $this->faker->randomFloat(2, 28, 210),
            'status' => 'active',
            'description' => $this->faker->sentence(16),
            'bio' => $this->faker->paragraph(3),
            'win_rate' => $this->faker->numberBetween(56, 91),
            'total_trades' => $this->faker->numberBetween(120, 4200),
            'price' => $this->faker->randomFloat(2, 100, 1500),
            'tag' => $this->faker->randomElement(['Macro', 'Swing', 'Scalp', 'Momentum', 'Quant']),
            'type' => 'main',
            'verification_status' => $this->faker->randomElement(['verified', 'verified', 'pending']),
            'verified_at' => now()->subDays($this->faker->numberBetween(10, 400)),
            'strategy_type' => $this->faker->randomElement(['Systematic macro', 'Momentum breakout', 'FX carry', 'Gold momentum', 'Crypto swing']),
            'risk_level' => $this->faker->randomElement(['low', 'medium', 'high']),
            'trading_style' => $this->faker->randomElement(['Intraday', 'Swing', 'Positional', 'Systematic']),
            'preferred_instruments' => $this->faker->randomElement(['EUR/USD, GBP/USD, XAU/USD', 'BTC/USD, ETH/USD, SOL/USD', 'NAS100, US30, SPX500']),
            'markets_traded' => $this->faker->randomElement(['Forex, Metals, Indices', 'Crypto, Forex', 'Indices, Commodities']),
            'monthly_roi' => $monthlyRoi,
            'yearly_roi' => $monthlyRoi * $this->faker->numberBetween(4, 8),
            'max_drawdown' => $drawdown,
            'aum' => $this->faker->randomFloat(2, 25000, 2500000),
            'consistency_score' => $this->faker->numberBetween(58, 96),
            'volatility_score' => $this->faker->numberBetween(22, 84),
            'confidence_score' => $this->faker->numberBetween(60, 98),
            'capital_preservation_score' => $this->faker->numberBetween(42, 95),
            'recommended_investor_profile' => $this->faker->randomElement(['Capital Preservation', 'Balanced Growth', 'Growth Seeker']),
            'minimum_allocation' => $this->faker->randomFloat(2, 100, 2500),
            'maximum_allocation' => $this->faker->randomFloat(2, 2500, 40000),
            'max_allocation_percent' => $this->faker->randomFloat(2, 15, 45),
            'management_fee_percent' => $this->faker->randomFloat(2, 0, 4),
            'performance_fee_percent' => $this->faker->randomFloat(2, 0, 20),
            'is_featured' => $this->faker->boolean(25),
            'is_ranked' => true,
        ];
    }
}
