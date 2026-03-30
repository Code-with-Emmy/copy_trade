@component('mail::message')
<p class="eyebrow">Plan Settlement</p>
# {{ $planName }} completed successfully

Dear {{ $name }},

Your investment cycle has ended and the final settlement has been recorded on your account.

@include('emails.partials.summary-table', [
    'rows' => [
        ['label' => 'Plan', 'value' => e($planName)],
        ['label' => 'Investment amount', 'value' => e($currency) . number_format((float) $amount, 2)],
        ['label' => 'Total profit', 'value' => e($currency) . number_format((float) $profit, 2)],
        ['label' => 'Total return', 'value' => e($currency) . number_format((float) $totalReturn, 2)],
        ['label' => 'Start date', 'value' => e($startDate)],
        ['label' => 'End date', 'value' => e($endDate)],
    ],
])

@component('mail::panel', ['color' => 'success'])
@if ($profit > 0)
The profit from this plan has been credited to your account balance.
@else
The plan has closed and your final account figures are available in the dashboard.
@endif
@endcomponent

@component('mail::button', ['url' => $siteUrl . '/dashboard'])
Open Dashboard
@endcomponent

Regards,<br>
{{ $siteName }} Team
@endcomponent
