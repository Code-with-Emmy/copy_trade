@props(['status' => 'verified'])

<span {{ $attributes->class([
    'inline-flex items-center gap-1 rounded-full border px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.18em]',
    'border-emerald-400/30 bg-emerald-400/10 text-emerald-200' => $status === 'verified',
    'border-amber-400/30 bg-amber-400/10 text-amber-200' => $status !== 'verified',
]) }}>
    <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
    {{ $status === 'verified' ? 'Verified' : 'Pending review' }}
</span>
