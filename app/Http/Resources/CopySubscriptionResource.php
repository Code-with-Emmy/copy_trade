<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CopySubscriptionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'reference' => $this->subscription_reference,
            'status' => $this->status,
            'amount' => (float) $this->allocation_amount,
            'current_balance' => (float) $this->current_balance,
            'realized_profit' => (float) $this->realized_profit,
            'unrealized_profit' => (float) $this->unrealized_profit,
            'copy_ratio' => (float) $this->copy_ratio,
            'risk_preference' => $this->risk_preference,
            'trader' => new TraderResource($this->whenLoaded('trader')),
        ];
    }
}
