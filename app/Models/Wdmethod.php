<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wdmethod extends Model
{
    use HasFactory;

    protected function inferredMethodtype(): string
    {
        $name = strtolower((string) ($this->attributes['name'] ?? ''));
        $cryptoNames = ['bitcoin', 'btc', 'ethereum', 'eth', 'usdt', 'usdc', 'bnb', 'litecoin', 'ltc', 'solana', 'sol', 'dogecoin', 'doge'];

        if (
            !empty($this->attributes['wallet_address'] ?? null) ||
            !empty($this->attributes['network'] ?? null) ||
            in_array($name, $cryptoNames, true)
        ) {
            return 'crypto';
        }

        return 'currency';
    }

    public function getChargesAmountAttribute()
    {
        $chargeType = $this->charges_type;

        if ($chargeType === 'percentage') {
            return $this->attributes['percentage_fee'] ?? 0;
        }

        if ($chargeType === 'fixed') {
            return $this->attributes['fixed_fee'] ?? 0;
        }

        if (isset($this->attributes['charges_amount'])) {
            return $this->attributes['charges_amount'];
        }

        return (float) ($this->attributes['fixed_fee'] ?? $this->attributes['percentage_fee'] ?? 0);
    }

    public function getChargesTypeAttribute()
    {
        if (isset($this->attributes['charges_type'])) {
            return $this->attributes['charges_type'];
        }

        if (($this->attributes['percentage_fee'] ?? 0) > 0) {
            return 'percentage';
        }

        return 'fixed';
    }

    public function getImgUrlAttribute()
    {
        return $this->attributes['img_url'] ?? $this->attributes['image'] ?? null;
    }

    public function getMethodtypeAttribute()
    {
        return $this->attributes['methodtype'] ?? $this->inferredMethodtype();
    }

    public function getWalletAddressAttribute()
    {
        return $this->attributes['wallet_address'] ?? null;
    }

    public function getNetworkAttribute()
    {
        return $this->attributes['network'] ?? null;
    }
}
