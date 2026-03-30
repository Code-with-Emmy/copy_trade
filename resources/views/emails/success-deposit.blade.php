@php
    $siteUrl = rtrim(config('app.url'), '/');
    $isProcessed = strcasecmp((string) $deposit->status, 'Processed') === 0;
    $depositDate = optional($deposit->created_at)->format('M d, Y g:i A') ?: now()->format('M d, Y g:i A');
@endphp
@component('mail::message')
<p class="eyebrow">{{ $foramin ? 'Admin Deposit Alert' : 'Deposit Update' }}</p>
# {{ $foramin ? 'New deposit received' : ($isProcessed ? 'Your deposit has been confirmed' : 'Your deposit is under review') }}

@if ($foramin)
A deposit has been recorded and is ready for operational review.
@else
Hello {{ $user->name }}, your funding request has been logged on the platform.
@endif

@include('emails.partials.summary-table', [
    'rows' => [
        ['label' => $foramin ? 'Client' : 'Account', 'value' => e($user->name)],
        ['label' => 'Amount', 'value' => e($user->currency) . number_format((float) $deposit->amount, 2)],
        ['label' => 'Method', 'value' => e($deposit->payment_mode ?? 'Manual deposit')],
        ['label' => 'Status', 'value' => e($deposit->status ?? 'Pending')],
        ['label' => 'Recorded at', 'value' => e($depositDate)],
    ],
])

@if ($foramin)
@component('mail::panel', ['color' => $isProcessed ? 'success' : 'warning'])
@if ($isProcessed)
This deposit has already been processed and the client balance should now reflect the credit.
@else
Review the deposit proof, payment details, and account status before approval.
@endif
@endcomponent

@component('mail::button', ['url' => $siteUrl . '/admin/dashboard'])
Open Admin Dashboard
@endcomponent
@else
@component('mail::panel', ['color' => $isProcessed ? 'success' : 'warning'])
@if ($isProcessed)
The funds are now available in your account balance.
@else
Processing normally completes after payment review. You will receive another email as soon as the deposit is approved.
@endif
@endcomponent

@component('mail::button', ['url' => $siteUrl . '/dashboard'])
Open Dashboard
@endcomponent

@component('mail::button', ['url' => $siteUrl . '/support', 'color' => 'success'])
Contact Support
@endcomponent
@endif

@component('mail::subcopy')
If you did not authorize this deposit, contact support immediately and include the deposit amount and recorded time shown above.
@endcomponent
@endcomponent
