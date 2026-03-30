<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCopySubscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'amount' => ['nullable', 'numeric', 'min:1'],
            'copy_ratio' => ['nullable', 'numeric', 'min:0.1', 'max:5'],
            'risk_preference' => ['nullable', 'in:conservative,balanced,aggressive'],
            'max_drawdown_guard' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'fee_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ];
    }
}
