@php
    $siteUrl = rtrim(config('app.url'), '/');
@endphp
@component('mail::message')
<p class="eyebrow">Account Setup</p>
# Your account is ready

Your access has been created successfully. Sign in once, then replace the temporary password immediately.

<div class="info-card text-center">
    <p class="muted">Temporary password</p>
    <div class="code-chip">{{ $demo->password }}</div>
</div>

@include('emails.partials.summary-table', [
    'rows' => [
        ['label' => 'Platform', 'value' => e($demo->sender)],
        ['label' => 'Support email', 'value' => e($demo->contact_email)],
        ['label' => 'Next step', 'value' => 'Sign in and change your password'],
    ],
])

@component('mail::button', ['url' => $siteUrl . '/login'])
Sign In
@endcomponent

@component('mail::panel', ['color' => 'warning'])
Do not keep using the temporary password. Replace it during your first session to secure the account.
@endcomponent

Regards,<br>
{{ $demo->sender }}
@endcomponent
