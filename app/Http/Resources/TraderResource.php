<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TraderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'avatar' => $this->photo,
            'verified' => $this->verification_status === 'verified',
            'strategy_type' => $this->strategy_type,
            'risk_level' => $this->risk_level,
            'monthly_roi' => (float) $this->monthly_roi,
            'yearly_roi' => (float) $this->yearly_roi,
            'max_drawdown' => (float) $this->max_drawdown,
            'win_rate' => (float) $this->win_rate,
            'followers' => (int) $this->followers,
            'aum' => (float) $this->aum,
            'markets_traded' => $this->markets_traded ? explode(',', $this->markets_traded) : [],
            'bio' => $this->bio ?: $this->description,
        ];
    }
}
