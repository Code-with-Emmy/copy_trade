@php
    $siteUrl = rtrim(config('app.url'), '/');
    $siteName = optional($settings)->site_name ?: config('app.name');
@endphp
@component('mail::message')
<p class="eyebrow">ROI Credit</p>
# New return credited to your account

Hello {{ $user->name }},

Your plan has generated a new return and the credit has been posted to your account balance.

@include('emails.partials.summary-table', [
    'rows' => [
        ['label' => 'Plan', 'value' => e($plan)],
        ['label' => 'Return amount', 'value' => e($user->currency) . number_format((float) $amount, 2)],
        ['label' => 'Credited on', 'value' => e($plandate)],
        ['label' => 'Status', 'value' => '<span class="status-pill">Credited</span>'],
    ],
])

<div class="info-card">
    <p><strong>Next actions</strong></p>
    <ul class="list-clean">
        <li>Review your updated balance and recent account activity.</li>
        <li>Decide whether to withdraw the return or compound it into another position.</li>
        <li>Track the plan from the dashboard for the next payout cycle.</li>
    </ul>
</div>

@component('mail::button', ['url' => $siteUrl . '/dashboard'])
View Dashboard
@endcomponent

@component('mail::subcopy')
This notice confirms a posted account credit. Investment performance can change over time, and past returns do not guarantee future outcomes. Review your full performance history inside {{ $siteName }} before making new allocation decisions.
@endcomponent
@endcomponent
