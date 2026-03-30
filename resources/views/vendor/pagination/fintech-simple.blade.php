@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm text-slate-500">
                Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/10">
                Previous
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/10">
                Next
            </a>
        @else
            <span class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm text-slate-500">
                Next
            </span>
        @endif
    </nav>
@endif
