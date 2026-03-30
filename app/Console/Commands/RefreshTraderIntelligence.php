<?php

namespace App\Console\Commands;

use App\Models\Trader;
use App\Services\LeaderboardService;
use App\Services\TraderAnalyticsService;
use Illuminate\Console\Command;

class RefreshTraderIntelligence extends Command
{
    protected $signature = 'copy:refresh-intelligence';

    protected $description = 'Refresh trader metrics and leaderboard snapshots';

    public function handle(
        TraderAnalyticsService $analyticsService,
        LeaderboardService $leaderboardService
    ): int {
        $this->info('Refreshing trader intelligence...');

        Trader::query()->chunkById(50, function ($traders) use ($analyticsService) {
            foreach ($traders as $trader) {
                $analyticsService->syncMetric($trader);
            }
        });

        $leaderboardService->snapshot();

        $this->info('Trader intelligence refreshed successfully.');

        return self::SUCCESS;
    }
}
