@php
    $siteUrl = rtrim(config('app.url'), '/');
    $isProcessed = strcasecmp((string) $withdrawal->status, 'Processed') === 0;
    $withdrawalDate = optional($withdrawal->created_at)->format('M d, Y g:i A') ?: now()->format('M d, Y g:i A');
@endphp
@component('mail::message')
<p class="eyebrow">{{ $foramin ? 'Admin Withdrawal Alert' : 'Withdrawal Update' }}</p>
# {{ $foramin ? 'Withdrawal request requires review' : ($isProcessed ? 'Your withdrawal has been processed' : 'Your withdrawal request is being reviewed') }}

@if ($foramin)
A withdrawal request has been submitted and should be checked before release.
@else
Hello {{ $user->name }}, here is the latest status for your withdrawal request.
@endif

@include('emails.partials.summary-table', [
    'rows' => [
        ['label' => $foramin ? 'Client' : 'Account', 'value' => e($user->name)],
        ['label' => 'Amount', 'value' => e($user->currency) . number_format((float) $withdrawal->amount, 2)],
        ['label' => 'Status', 'value' => e($withdrawal->status ?? 'Pending')],
        ['label' => 'Reference', 'value' => '#' . e($withdrawal->id ?? ('WDR' . time()))],
        ['label' => 'Submitted at', 'value' => e($withdrawalDate)],
    ],
])

@if ($foramin)
@component('mail::panel')
Confirm KYC, payout details, and available balance before marking this withdrawal as processed.
@endcomponent

@component('mail::button', ['url' => $siteUrl . '/admin/dashboard'])
Open Admin Dashboard
@endcomponent
@else
@component('mail::panel', ['color' => $isProcessed ? 'success' : 'warning'])
@if ($isProcessed)
The transfer has been released. Final arrival time depends on the payment rail used.
@else
The request is in queue for compliance and payout review. You will be notified again when it is approved.
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
If you did not request this withdrawal, contact support immediately and secure your account credentials.
@endcomponent
@endcomponent
