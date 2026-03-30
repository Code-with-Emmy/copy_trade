<?php

namespace App\Services;

use App\Models\LeaderboardSnapshot;
use App\Models\Trader;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class LeaderboardService
{
    public function boards(): array
    {
        return Cache::remember('leaderboards.snapshot', now()->addMinutes(15), function () {
            return [
                'top_roi' => $this->query('top_roi', fn () => Trader::query()->active()->orderByDesc('monthly_roi')->limit(10)->get()),
                'lowest_drawdown' => $this->query('lowest_drawdown', fn () => Trader::query()->active()->orderBy('max_drawdown')->limit(10)->get()),
                'most_copied' => $this->query('most_copied', fn () => Trader::query()->active()->orderByDesc('followers')->limit(10)->get()),
                'trending' => $this->query('trending', fn () => Trader::query()->active()->orderByDesc('is_featured')->orderByDesc('monthly_roi')->orderByDesc('followers')->limit(10)->get()),
            ];
        });
    }

    public function snapshot(): void
    {
        foreach ($this->boards() as $board => $traders) {
            foreach ($traders as $index => $trader) {
                LeaderboardSnapshot::query()->updateOrCreate(
                    [
                        'copytrading_id' => $trader->getKey(),
                        'board' => $board,
                        'snapshot_date' => now()->toDateString(),
                    ],
                    [
                        'rank' => $index + 1,
                        'score' => match ($board) {
                            'top_roi' => $trader->monthly_roi,
                            'lowest_drawdown' => 100 - $trader->max_drawdown,
                            'most_copied' => $trader->followers,
                            default => ($trader->monthly_roi * 3) + $trader->followers,
                        },
                        'meta' => [
                            'name' => $trader->name,
                            'risk_level' => $trader->risk_level,
                        ],
                    ]
                );
            }
        }
    }

    private function query(string $board, callable $resolver): Collection
    {
        return Cache::remember("leaderboard.{$board}", now()->addMinutes(15), $resolver);
    }
}
