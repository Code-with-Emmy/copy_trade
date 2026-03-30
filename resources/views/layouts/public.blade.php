<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="@yield('meta_description', $settings->site_name . ' is a premium copy trading platform where investors follow verified traders with transparent risk controls.')">
    <title>@yield('title', 'BitCloven') | {{ $settings->site_name }}</title>

    {{-- BitCloven Core Assets --}}
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('head')
</head>

<body class="bg-black text-white antialiased">

    <x-landing.navbar />

    <main>
        @if (session('success'))
            <div class="container mx-auto px-4 mt-6">
                <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error') || $errors->any())
            <div class="container mx-auto px-4 mt-6">
                <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-sm">
                    {{ session('error') ?: $errors->first() }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <x-landing.footer />

    @stack('scripts')

    {{-- BitCloven Core Scripts --}}
    <script src="{{ asset('script.js') }}"></script>
</body>

</html>