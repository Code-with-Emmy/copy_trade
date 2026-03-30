@props(['level' => 'medium'])

@php
    $tone = match (strtolower($level)) {
        'low' => 'border-emerald-400/30 bg-emerald-400/10 text-emerald-200',
        'high' => 'border-orange-400/30 bg-orange-400/10 text-orange-200',
        'very high' => 'border-rose-400/30 bg-rose-400/10 text-rose-200',
        default => 'border-sky-400/30 bg-sky-400/10 text-sky-200',
    };
@endphp

<span {{ $attributes->class("inline-flex items-center rounded-full border px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] {$tone}") }}>
    {{ $level }}
</span>
