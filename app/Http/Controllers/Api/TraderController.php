<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TraderMarketplaceRequest;
use App\Http\Resources\TraderResource;
use App\Models\Trader;
use App\Services\TraderMarketplaceService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TraderController extends Controller
{
    private TraderMarketplaceService $marketplaceService;

    public function __construct(TraderMarketplaceService $marketplaceService)
    {
        $this->marketplaceService = $marketplaceService;
    }

    public function index(TraderMarketplaceRequest $request): AnonymousResourceCollection
    {
        return TraderResource::collection($this->marketplaceService->paginate($request->validated()));
    }

    public function show(string $slug): TraderResource
    {
        $trader = Trader::query()->where('slug', $slug)->orWhere('id', $slug)->firstOrFail();

        return new TraderResource($trader);
    }
}
