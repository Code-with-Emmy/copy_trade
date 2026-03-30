<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StartCopySubscriptionRequest;
use App\Http\Requests\UpdateCopySubscriptionRequest;
use App\Http\Resources\CopySubscriptionResource;
use App\Models\CopySubscription;
use App\Models\Trader;
use App\Services\CopySubscriptionService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    private CopySubscriptionService $subscriptionService;

    public function __construct(CopySubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function index(): AnonymousResourceCollection
    {
        return CopySubscriptionResource::collection(
            CopySubscription::query()
                ->with('trader')
                ->forUser(Auth::id())
                ->latest()
                ->paginate(12)
        );
    }

    public function store(StartCopySubscriptionRequest $request): CopySubscriptionResource
    {
        $trader = Trader::query()->active()->findOrFail($request->integer('expert_id'));
        $subscription = $this->subscriptionService->subscribe(Auth::user(), $trader, $request->validated());

        return new CopySubscriptionResource($subscription->load('trader'));
    }

    public function update(UpdateCopySubscriptionRequest $request, int $id): CopySubscriptionResource
    {
        $subscription = CopySubscription::query()->findOrFail($id);
        abort_unless((int) $subscription->user === (int) Auth::id(), 403);

        return new CopySubscriptionResource(
            $this->subscriptionService->update($subscription, $request->validated())->load('trader')
        );
    }
}
