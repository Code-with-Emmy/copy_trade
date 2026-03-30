@php
    $siteName = optional($settings)->site_name ?: config('app.name');
    $siteUrl = rtrim(config('app.url'), '/');
@endphp
@component('mail::message')
<p class="eyebrow">Welcome Aboard</p>
# Welcome to {{ $siteName }}, {{ $user->name }}

<p class="lead">Your account is live and the dashboard is ready. The next step is to secure the profile, choose a funding method, and begin using the platform.</p>

@include('emails.partials.summary-table', [
    'rows' => [
        ['label' => 'Account holder', 'value' => e($user->name)],
        ['label' => 'Email', 'value' => e($user->email)],
        ['label' => 'Account status', 'value' => '<span class="status-pill">Active</span>'],
        ['label' => 'Dashboard', 'value' => 'Ready to access'],
    ],
])

<div class="info-card">
    <p><strong>Start here</strong></p>
    <ul class="list-clean">
        <li>Complete your profile and verification details.</li>
        <li>Review available payment methods before making your first deposit.</li>
        <li>Explore plans, signals, or copy trading from the dashboard.</li>
    </ul>
</div>

@component('mail::button', ['url' => $siteUrl . '/dashboard'])
Open Dashboard
@endcomponent

@component('mail::button', ['url' => $siteUrl . '/support', 'color' => 'success'])
Contact Support
@endcomponent

@component('mail::subcopy')
Trading and investment activity involve risk. Review the platform terms and risk disclosure inside {{ $siteName }} before committing capital.
@endcomponent
@endcomponent
