<?php

namespace App\Services;

use App\Models\FeaturedTrader;
use App\Models\Trader;
use App\Models\TraderWatchlist;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TraderMarketplaceService
{
    private TraderAnalyticsService $analyticsService;

    public function __construct(TraderAnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    public function paginate(array $filters = []): LengthAwarePaginator
    {
        $query = Trader::query()
            ->active()
            ->with(['metric', 'featuredPlacement'])
            ->when(data_get($filters, 'search'), function (Builder $query, string $search) {
                $query->where(function (Builder $inner) use ($search) {
                    $inner->where('name', 'like', '%' . $search . '%')
                        ->orWhere('tag', 'like', '%' . $search . '%')
                        ->orWhere('strategy_type', 'like', '%' . $search . '%')
                        ->orWhere('markets_traded', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%');
                });
            })
            ->when(filled(data_get($filters, 'risk_level')), fn (Builder $query) => $query->where('risk_level', data_get($filters, 'risk_level')))
            ->when(filled(data_get($filters, 'strategy_type')), fn (Builder $query) => $query->where('strategy_type', data_get($filters, 'strategy_type')))
            ->when(filled(data_get($filters, 'verified')), fn (Builder $query) => $query->where('verification_status', data_get($filters, 'verified') ? 'verified' : 'pending'))
            ->when(filled(data_get($filters, 'min_roi')), fn (Builder $query) => $query->where('monthly_roi', '>=', (float) data_get($filters, 'min_roi')))
            ->when(filled(data_get($filters, 'max_drawdown')), fn (Builder $query) => $query->where('max_drawdown', '<=', (float) data_get($filters, 'max_drawdown')))
            ->when(filled(data_get($filters, 'min_followers')), fn (Builder $query) => $query->where('followers', '>=', (int) data_get($filters, 'min_followers')));

        $this->applySort($query, data_get($filters, 'sort', 'top_returns'));

        return $query->paginate((int) data_get($filters, 'per_page', 12))->withQueryString();
    }

    public function sections(): array
    {
        return [
            'featured' => Trader::query()
                ->active()
                ->where(function (Builder $query) {
                    $query->where('is_featured', true)
                        ->orWhereIn('id', FeaturedTrader::query()->where('is_active', true)->pluck('copytrading_id'));
                })
                ->with('metric')
                ->limit(4)
                ->get(),
            'top_ranked' => Trader::query()->active()->with('metric')->orderByDesc('monthly_roi')->limit(5)->get(),
            'trending' => Trader::query()->active()->with('metric')->orderByDesc('followers')->orderByDesc('monthly_roi')->limit(5)->get(),
            'recent' => Trader::query()->active()->latest()->limit(5)->get(),
            'watchlist_ids' => Auth::check()
                ? TraderWatchlist::query()->where('user_id', Auth::id())->pluck('copytrading_id')->all()
                : [],
        ];
    }

    public function traderProfile(Trader $trader): array
    {
        $this->analyticsService->hydrateTrader($trader);

        return array_merge(
            $this->analyticsService->performanceSummary($trader),
            [
                'active_copiers' => $trader->subscriptions()->where('status', 'active')->count(),
                'watchlisted' => Auth::check()
                    ? TraderWatchlist::query()
                        ->where('user_id', Auth::id())
                        ->where('copytrading_id', $trader->getKey())
                        ->exists()
                    : false,
            ]
        );
    }

    public function toggleWatchlist(int $userId, Trader $trader): bool
    {
        $existing = TraderWatchlist::query()
            ->where('user_id', $userId)
            ->where('copytrading_id', $trader->getKey())
            ->first();

        if ($existing) {
            $existing->delete();

            return false;
        }

        TraderWatchlist::query()->create([
            'user_id' => $userId,
            'copytrading_id' => $trader->getKey(),
        ]);

        return true;
    }

    private function applySort(Builder $query, string $sort): void
    {
        match ($sort) {
            'trending' => $query->orderByDesc('followers')->orderByDesc('monthly_roi'),
            'most_copied' => $query->orderByDesc('followers')->orderByDesc('total_trades'),
            'lowest_risk' => $query->orderBy('max_drawdown')->orderByDesc('win_rate'),
            'recently_added' => $query->latest(),
            default => $query->orderByDesc('monthly_roi')->orderByDesc('yearly_roi'),
        };
    }
}
