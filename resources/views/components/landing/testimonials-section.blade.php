@props(['testimonials' => collect()])

@php
    $defaultTestimonials = collect([
        [
            'name' => 'Maya Kingston',
            'position' => 'Private Investor · London',
            'what_is_said' => 'The trader analytics are incredibly clean. The risk labels helped me avoid over-allocating to volatile strategies early in my journey. Genuinely impressed by the transparency.',
            'picture' => null,
            'avatar_idx' => 1,
        ],
        [
            'name' => 'David Orji',
            'position' => 'Portfolio Builder · Lagos',
            'what_is_said' => 'I like seeing wallet flow, copied trades, and subscriptions in a single dashboard without hunting through menus. The execution speed is exactly what I needed.',
            'picture' => null,
            'avatar_idx' => 2,
        ],
        [
            'name' => 'Lina Brooks',
            'position' => 'Growth Investor · New York',
            'what_is_said' => 'The platform feels premium in every sense. It explains risk and fees upfront before I commit capital. I actually understand my positions now.',
            'picture' => null,
            'avatar_idx' => 3,
        ],
    ]);
    $items = collect($testimonials)->isNotEmpty() ? collect($testimonials)->values()->take(3) : $defaultTestimonials;
@endphp

<section id="testimonials" class="mx-auto mt-28 max-w-7xl px-4 sm:px-6 lg:px-8">

    {{-- Section header --}}
    <div class="text-center max-w-3xl mx-auto mb-12 reveal">
        <span
            class="inline-block mb-3 text-xs font-semibold uppercase tracking-[0.25em] text-emerald-400">Testimonials</span>
        <h2 class="font-display text-3xl font-bold text-white sm:text-4xl leading-tight">
            Trusted by thousands of<br class="hidden sm:block"> serious investors worldwide.
        </h2>
    </div>

    {{-- Testimonial cards grid --}}
    <div class="mt-10 grid gap-6 lg:grid-cols-3 reveal" style="transition-delay:.1s">
        @foreach ($items as $index => $item)
            @php
                $name = $item instanceof \Illuminate\Database\Eloquent\Model ? $item->name : data_get($item, 'name', 'Investor');
                $position = $item instanceof \Illuminate\Database\Eloquent\Model ? $item->position : data_get($item, 'position', 'Platform Investor');
                $said = $item instanceof \Illuminate\Database\Eloquent\Model ? $item->what_is_said : data_get($item, 'what_is_said', '');
                $picture = $item instanceof \Illuminate\Database\Eloquent\Model ? $item->picture : data_get($item, 'picture');
                $avatarIdx = (($index % 3) + 1);
                $avatarSrc = $picture ? asset('storage/' . $picture) : asset('img/blockit/in-testimoni-' . $avatarIdx . '.png');
            @endphp

            <article
                class="glass group flex flex-col rounded-3xl p-6 transition duration-300 hover:-translate-y-1 hover:border-white/20">
                {{-- Stars --}}
                <div class="flex items-center gap-1 text-amber-400 mb-4">
                    @for ($i = 0; $i < 5; $i++)
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.539 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.783.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.719c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 00.95-.69l1.07-3.292z" />
                        </svg>
                    @endfor
                    <span class="ml-2 text-xs font-semibold text-slate-500">5.0</span>
                </div>

                {{-- Quote --}}
                <div class="mb-5 flex-1">
                    <svg class="mb-3 h-6 w-6 text-emerald-400/40" fill="currentColor" viewBox="0 0 32 32">
                        <path
                            d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                    </svg>
                    <p class="text-sm leading-7 text-slate-200">{{ $said }}</p>
                </div>

                {{-- Author --}}
                <div class="flex items-center gap-4 border-t border-white/8 pt-5">
                    <img src="{{ $avatarSrc }}" alt="{{ $name }} avatar"
                        class="h-12 w-12 rounded-2xl object-cover border border-white/10" loading="lazy">
                    <div>
                        <p class="font-semibold text-white text-sm">{{ $name }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $position }}</p>
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    {{-- Press logos strip --}}
    <div class="mt-16 reveal" style="transition-delay:.2s">
        <p class="text-center text-xs font-semibold uppercase tracking-[0.24em] text-slate-600 mb-6">Covered by leading
            financial media</p>
        <div class="flex flex-wrap items-center justify-center gap-8">
            @foreach (['in-theramanuel-press-1.svg', 'in-theramanuel-press-2.svg', 'in-theramanuel-press-3.svg', 'in-theramanuel-press-4.svg', 'in-theramanuel-press-5.svg'] as $logo)
                <img src="{{ asset('img/' . $logo) }}" alt="Media outlet"
                    class="h-7 w-auto opacity-40 grayscale transition hover:opacity-80 hover:grayscale-0" loading="lazy">
            @endforeach
        </div>
    </div>
</section>