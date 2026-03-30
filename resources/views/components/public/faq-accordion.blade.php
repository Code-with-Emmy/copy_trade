@props(['items' => collect()])

<div class="space-y-4" x-data="{ active: 0 }">
    @foreach ($items as $index => $item)
        <div class="glass overflow-hidden rounded-3xl">
            <button type="button" class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left" @click="active = active === {{ $index }} ? null : {{ $index }}">
                <span class="text-base font-semibold text-white">{{ $item->question }}</span>
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-white/10 text-slate-300">
                    <svg class="h-4 w-4 transition" :class="{ 'rotate-45': active === {{ $index }} }" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7H5" />
                    </svg>
                </span>
            </button>
            <div x-cloak x-show="active === {{ $index }}" x-transition class="border-t border-white/5 px-6 pb-6 pt-4 text-sm leading-7 text-slate-400">
                {{ $item->answer }}
            </div>
        </div>
    @endforeach
</div>
