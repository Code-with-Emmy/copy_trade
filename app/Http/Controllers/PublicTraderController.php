<?php

namespace App\Http\Controllers;

use App\Http\Requests\TraderMarketplaceRequest;
use App\Models\Settings;
use App\Models\Trader;
use App\Services\LeaderboardService;
use App\Services\TraderMarketplaceService;
use Illuminate\View\View;

class PublicTraderController extends Controller
{
    private TraderMarketplaceService $marketplaceService;
    private LeaderboardService $leaderboardService;

    public function __construct(
        TraderMarketplaceService $marketplaceService,
        LeaderboardService $leaderboardService
    ) {
        $this->marketplaceService = $marketplaceService;
        $this->leaderboardService = $leaderboardService;
    }

    public function index(TraderMarketplaceRequest $request): View
    {
        $filters = $request->validated();

        return view('public.traders.index', [
            'title' => 'Trader Discovery',
            'settings' => Settings::query()->find(1),
            'filters' => $filters,
            'traders' => $this->marketplaceService->paginate($filters),
            'sections' => $this->marketplaceService->sections(),
            'leaderboards' => $this->leaderboardService->boards(),
        ]);
    }

    public function show(string $slug): View
    {
        $trader = Trader::query()
            ->with(['metric', 'performanceHistory'])
            ->where('slug', $slug)
            ->orWhere('id', $slug)
            ->firstOrFail();

        return view('public.traders.show', [
            'title' => $trader->name . ' Performance',
            'settings' => Settings::query()->find(1),
            'profile' => $this->marketplaceService->traderProfile($trader),
            'leaderboards' => $this->leaderboardService->boards(),
        ]);
    }
}
