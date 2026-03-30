@php
    $siteUrl = rtrim(config('app.url'), '/');
@endphp
@component('mail::message')
<p class="eyebrow">Plan Completion</p>
# {{ $demo->receiver_plan }} has closed

Hello {{ $demo->receiver_name }},

Your investment cycle has been completed and the returned capital has been moved back to your available balance.

@include('emails.partials.summary-table', [
    'rows' => [
        ['label' => 'Plan', 'value' => e($demo->receiver_plan)],
        ['label' => 'Amount credited', 'value' => e($demo->received_amount)],
        ['label' => 'Completed on', 'value' => e($demo->date)],
    ],
])

@component('mail::panel', ['color' => 'success'])
Your funds are available for withdrawal or reinvestment from the dashboard.
@endcomponent

@component('mail::button', ['url' => $siteUrl . '/dashboard'])
Open Dashboard
@endcomponent

Regards,<br>
{{ $demo->sender }}
@endcomponent
