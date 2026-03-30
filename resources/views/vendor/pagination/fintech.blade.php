@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="text-sm text-slate-400">
            Showing
            <span class="font-semibold text-white">{{ $paginator->firstItem() }}</span>
            to
            <span class="font-semibold text-white">{{ $paginator->lastItem() }}</span>
            of
            <span class="font-semibold text-white">{{ $paginator->total() }}</span>
            results
        </div>

        <div class="flex flex-wrap items-center gap-2">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm text-slate-500">
                    Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/10">
                    Previous
                </a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="inline-flex items-center px-2 text-sm text-slate-500">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="inline-flex min-w-[42px] items-center justify-center rounded-2xl bg-gradient-to-r from-cyan-400 via-sky-400 to-emerald-400 px-3 py-2 text-sm font-semibold text-slate-950">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="inline-flex min-w-[42px] items-center justify-center rounded-2xl border border-white/10 bg-white/5 px-3 py-2 text-sm font-semibold text-white transition hover:bg-white/10">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/10">
                    Next
                </a>
            @else
                <span class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm text-slate-500">
                    Next
                </span>
            @endif
        </div>
    </nav>
@endif
