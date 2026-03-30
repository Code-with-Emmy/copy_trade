<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TraderMarketplaceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:120'],
            'min_roi' => ['nullable', 'numeric', 'min:-100', 'max:1000'],
            'max_drawdown' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'risk_level' => ['nullable', 'in:low,medium,high,very high'],
            'min_followers' => ['nullable', 'integer', 'min:0'],
            'verified' => ['nullable', 'boolean'],
            'strategy_type' => ['nullable', 'string', 'max:64'],
            'sort' => ['nullable', 'in:top_returns,trending,most_copied,lowest_risk,recently_added'],
            'per_page' => ['nullable', 'integer', 'min:6', 'max:24'],
        ];
    }
}
