@php
    $siteUrl = rtrim(config('app.url'), '/');
@endphp
@component('mail::message')
<p class="eyebrow">Security Verification</p>
# Your sign-in code

Use the one-time code below to finish signing in.

<div class="info-card text-center">
    <p class="muted">Verification code</p>
    <div class="code-chip">{!! $demo->message !!}</div>
</div>

@include('emails.partials.summary-table', [
    'rows' => [
        ['label' => 'Request type', 'value' => 'Two-factor authentication'],
        ['label' => 'Issued at', 'value' => now()->format('M d, Y g:i A')],
        ['label' => 'Validity', 'value' => 'Single use and short-lived'],
    ],
])

@component('mail::panel', ['color' => 'warning'])
If this code was not requested by you, change your password immediately and review recent account activity.
@endcomponent

@component('mail::button', ['url' => $siteUrl . '/support'])
Contact Security Support
@endcomponent

Thanks,<br>
{{ $demo->sender }}
@endcomponent
