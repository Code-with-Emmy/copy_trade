{{--
Newsletter / Intel Strip — mirrors BitCloven's "Copy trading intelligence" footer strip.
A clean email capture banner before the final CTA.
--}}
<section id="newsletter" class="mx-auto mt-28 max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="glass-bright relative overflow-hidden rounded-[32px] px-8 py-12 sm:px-12 reveal">
        {{-- Background accent --}}
        <div class="pointer-events-none absolute -right-16 -top-16 h-64 w-64 rounded-full bg-emerald-400/8 blur-[80px]">
        </div>
        <div class="pointer-events-none absolute -bottom-8 left-1/3 h-48 w-48 rounded-full bg-sky-400/6 blur-[80px]">
        </div>

        <div class="relative grid gap-8 lg:grid-cols-[1.2fr,.8fr] lg:items-center">
            <div>
                <span class="inline-block mb-3 text-xs font-bold uppercase tracking-[0.28em] text-emerald-400">Copy
                    Trading Intelligence</span>
                <h2 class="font-display text-2xl font-bold text-white sm:text-3xl leading-tight">
                    Trader spotlights, performance breakdowns,<br class="hidden sm:block"> and market briefs — weekly.
                </h2>
                <p class="mt-3 text-sm leading-7 text-slate-400">
                    Subscribe for insights tailored to your copied strategies and the traders you follow.
                </p>
            </div>
            <form class="flex flex-col gap-3 sm:flex-row lg:flex-col xl:flex-row" onsubmit="return false;">
                <input type="email" placeholder="Your email address"
                    class="w-full flex-1 rounded-full border border-white/12 bg-white/5 px-5 py-3.5 text-sm text-white placeholder:text-slate-500 focus:border-emerald-400/40 focus:bg-white/8 focus:outline-none transition"
                    aria-label="Email address">
                <button type="submit"
                    class="shrink-0 rounded-full bg-emerald-400 px-6 py-3.5 text-sm font-bold text-slate-950 shadow-glow transition hover:translate-y-[-1px] hover:bg-emerald-300">
                    Subscribe
                </button>
            </form>
        </div>
    </div>
</section>