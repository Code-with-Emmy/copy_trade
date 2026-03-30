<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StartCopySubscriptionRequest;
use App\Http\Requests\TraderMarketplaceRequest;
use App\Http\Requests\UpdateCopySubscriptionRequest;
use App\Models\CopySubscription;
use App\Models\Settings;
use App\Models\Trader;
use App\Services\CopySubscriptionService;
use App\Services\LeaderboardService;
use App\Services\PortfolioService;
use App\Services\TraderMarketplaceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CopyTradingController extends Controller
{
    private TraderMarketplaceService $marketplaceService;
    private CopySubscriptionService $subscriptionService;
    private PortfolioService $portfolioService;
    private LeaderboardService $leaderboardService;

    public function __construct(
        TraderMarketplaceService $marketplaceService,
        CopySubscriptionService $subscriptionService,
        PortfolioService $portfolioService,
        LeaderboardService $leaderboardService
    ) {
        $this->marketplaceService = $marketplaceService;
        $this->subscriptionService = $subscriptionService;
        $this->portfolioService = $portfolioService;
        $this->leaderboardService = $leaderboardService;
    }

    public function dashboard(): View
    {
        $settings = Settings::query()->find(1);
        $user = Auth::user();
        $portfolio = $this->portfolioService->summary($user);

        return view('user.copy.dashboard', [
            'title' => 'Copy Trading Command Center',
            'settings' => $settings,
            'portfolio' => $portfolio,
            'leaderboards' => $this->leaderboardService->boards(),
        ]);
    }

    public function portfolio(): View
    {
        return $this->dashboard();
    }

    public function experts(TraderMarketplaceRequest $request): View
    {
        $settings = Settings::query()->find(1);
        $filters = $request->validated();

        return view('user.copy.experts', [
            'title' => 'Trader Marketplace',
            'settings' => $settings,
            'filters' => $filters,
            'traders' => $this->marketplaceService->paginate($filters),
            'sections' => $this->marketplaceService->sections(),
            'leaderboards' => $this->leaderboardService->boards(),
        ]);
    }

    public function show(string $slug): View
    {
        $settings = Settings::query()->find(1);
        $trader = Trader::query()
            ->with(['metric', 'performanceHistory'])
            ->where('slug', $slug)
            ->orWhere('id', $slug)
            ->firstOrFail();

        $profile = $this->marketplaceService->traderProfile($trader);

        return view('user.copy.show', [
            'title' => $trader->name . ' Performance Profile',
            'settings' => $settings,
            'profile' => $profile,
        ]);
    }

    public function startCopyTrading(StartCopySubscriptionRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $trader = Trader::query()->active()->findOrFail($request->integer('expert_id'));

        $this->authorize('subscribe', $trader);

        if ($request->float('amount') < max((float) $trader->price, (float) ($trader->minimum_allocation ?: 0))) {
            return back()->with('error', "Minimum allocation for {$trader->name} is {$user->currency}" . number_format(max((float) $trader->price, (float) ($trader->minimum_allocation ?: 0)), 2) . '.');
        }

        if ($trader->maximum_allocation && $request->float('amount') > (float) $trader->maximum_allocation) {
            return back()->with('error', "Maximum allocation for {$trader->name} is {$user->currency}" . number_format((float) $trader->maximum_allocation, 2) . '.');
        }

        $existing = CopySubscription::query()
            ->forUser($user->getKey())
            ->where('cptrading', $trader->getKey())
            ->whereIn('status', ['active', 'paused'])
            ->exists();

        if ($existing) {
            return back()->with('error', "You already have a live subscription with {$trader->name}.");
        }

        try {
            $this->subscriptionService->subscribe($user, $trader, $request->validated());

            return redirect()->route('copy.dashboard')
                ->with('success', "Copy subscription started for {$trader->name}.");
        } catch (\Throwable $exception) {
            report($exception);

            return back()->withInput()->with('error', $exception->getMessage() ?: 'Unable to start the copy subscription right now.');
        }
    }

    public function stopCopyTrading(int $id): RedirectResponse
    {
        $subscription = CopySubscription::query()
            ->with(['investor', 'trader'])
            ->findOrFail($id);

        $this->authorize('delete', $subscription);

        try {
            $this->subscriptionService->stop($subscription);

            return back()->with('success', 'Copy subscription closed and wallet balance updated.');
        } catch (\Throwable $exception) {
            report($exception);

            return back()->with('error', $exception->getMessage() ?: 'Unable to stop this copy subscription right now.');
        }
    }

    public function pause(int $id): RedirectResponse
    {
        $subscription = CopySubscription::query()->findOrFail($id);
        $this->authorize('update', $subscription);

        $this->subscriptionService->pause($subscription);

        return back()->with('success', 'Copy subscription paused.');
    }

    public function resume(int $id): RedirectResponse
    {
        $subscription = CopySubscription::query()->findOrFail($id);
        $this->authorize('update', $subscription);

        $this->subscriptionService->resume($subscription);

        return back()->with('success', 'Copy subscription resumed.');
    }

    public function updateSubscription(UpdateCopySubscriptionRequest $request, int $id): RedirectResponse
    {
        $subscription = CopySubscription::query()->findOrFail($id);
        $this->authorize('update', $subscription);

        $this->subscriptionService->update($subscription, $request->validated());

        return back()->with('success', 'Subscription preferences updated.');
    }

    public function toggleWatchlist(int $traderId): RedirectResponse
    {
        $trader = Trader::query()->findOrFail($traderId);
        $watchlisted = $this->marketplaceService->toggleWatchlist(Auth::id(), $trader);

        return back()->with('success', $watchlisted
            ? "{$trader->name} added to your watchlist."
            : "{$trader->name} removed from your watchlist.");
    }

    public function analytics(int $id): JsonResponse
    {
        $subscription = CopySubscription::query()
            ->with(['trader.metric', 'copiedTrades'])
            ->findOrFail($id);

        $this->authorize('view', $subscription);

        return response()->json([
            'subscription' => $subscription,
            'copied_trades' => $subscription->copiedTrades()->latest('opened_at')->limit(20)->get(),
            'history' => $subscription->history()->latest()->limit(20)->get(),
        ]);
    }
}
