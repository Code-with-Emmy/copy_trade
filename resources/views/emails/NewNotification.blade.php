@php
    $siteUrl = rtrim(config('app.url'), '/');
    $supportEmail = optional($settings)->contact_email ?: config('mail.from.address');
@endphp
@component('mail::message')
<p class="eyebrow">Account Notification</p>
# {{ $salutaion ?: 'Hello' }} {{ $recipient }},

<p class="lead">A new update is available for your account.</p>

@include('emails.partials.summary-table', [
    'rows' => [
        ['label' => 'Notice type', 'value' => e($subject)],
        ['label' => 'Sent at', 'value' => now()->format('M d, Y g:i A')],
        ['label' => 'Recipient', 'value' => e($recipient)],
    ],
])

{!! $body !!}

@if ($attachment)
<div class="divider"></div>
<p class="eyebrow">Attachment</p>
<div class="info-card text-center">
    <p class="muted">Review the attached reference below.</p>
    <img src="{{ $message->embed(asset('storage/' . $attachment)) }}" alt="Attachment" style="max-width: 100%; border-radius: 12px;">
</div>
@endif

@component('mail::panel')
Need help with this update? Reply to this email or contact the support desk and include the notice subject for faster handling.
@endcomponent

@if ($url)
@component('mail::button', ['url' => $url])
Open Related Page
@endcomponent
@endif

@component('mail::button', ['url' => $siteUrl . '/support', 'color' => 'success'])
Contact Support
@endcomponent

@component('mail::subcopy')
{{ config('app.name') }} will never ask for your password or recovery code by email. If this message looks suspicious, contact {{ $supportEmail ?: 'support' }} before taking any action.
@endcomponent
@endcomponent
