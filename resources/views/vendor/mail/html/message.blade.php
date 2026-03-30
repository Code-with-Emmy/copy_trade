@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
@if (isset($settings) && !empty($settings->logo))
<img src="{{ asset('storage/' . $settings->logo) }}" alt="{{ config('app.name') }}" class="logo">
@else
<span class="wordmark">{{ config('app.name') }}</span>
@endif
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ isset($settings) && !empty($settings->site_name) ? $settings->site_name : config('app.name') }}. @lang('All rights reserved.')<br>
Operational updates, account alerts, and security notices from {{ isset($settings) && !empty($settings->site_name) ? $settings->site_name : config('app.name') }}.<br>
@if (isset($settings) && !empty($settings->contact_email))
Support: <a href="mailto:{{ $settings->contact_email }}">{{ $settings->contact_email }}</a><br>
@endif
<a href="{{ rtrim(config('app.url'), '/') }}/terms">Terms</a> •
<a href="{{ rtrim(config('app.url'), '/') }}/privacy">Privacy</a> •
<a href="{{ rtrim(config('app.url'), '/') }}/risk-disclosure">Risk Disclosure</a>
@endcomponent
@endslot
@endcomponent
