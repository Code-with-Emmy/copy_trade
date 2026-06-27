<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="@yield('meta_description', $settings->site_name . ' is a premium copy trading platform where investors follow verified traders with transparent risk controls.')">
    <title>@yield('title', config('app.name')) | {{ $settings->site_name }}</title>

    {{-- BitCloven Core Assets --}}
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js@1.12.0/src/toastify.min.css">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('head')
</head>

<body class="bg-black text-white antialiased">

    <x-landing.navbar />

    <main class="min-h-screen">
        @yield('content')
    </main>

    

    @stack('scripts')

    {{-- BitCloven Core Scripts --}}
    <script src="{{ asset('script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js@1.12.0/src/toastify.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function showToast(message, type = 'info') {
                if (!message) return;

                const backgroundColors = {
                    success: 'linear-gradient(to right, #16a34a, #059669)',
                    error: 'linear-gradient(to right, #dc2626, #ef4444)',
                    info: 'linear-gradient(to right, #334155, #475569)',
                };

                Toastify({
                    text: message,
                    duration: 6000,
                    close: true,
                    gravity: 'top',
                    position: 'right',
                    stopOnFocus: true,
                    backgroundColor: backgroundColors[type] || backgroundColors.info,
                    className: 'toastify',
                }).showToast();
            }

            const messages = [];
            @if(session('success'))
                messages.push({ message: @json(session('success')), type: 'success' });
            @endif
            @if(session('status'))
                messages.push({ message: @json(session('status')), type: 'success' });
            @endif
            @if(session('error'))
                messages.push({ message: @json(session('error')), type: 'error' });
            @endif
            @if(session('message'))
                messages.push({ message: @json(session('message')), type: 'info' });
            @endif
            @if($errors->any())
                @foreach($errors->all() as $error)
                    messages.push({ message: @json($error), type: 'error' });
                @endforeach
            @endif

            messages.forEach((toast, index) => {
                setTimeout(() => showToast(toast.message, toast.type), index * 250);
            });
        });
    </script>
</body>

</html>