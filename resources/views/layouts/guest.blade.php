<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name')) — MeyveTerevez</title>
    <meta name="description" content="@yield('description', __t('carousel.slide1_desc'))">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        window.__locale = @json(app()->getLocale());
        window.__t = @json(app(\App\Services\TranslationService::class)->getAllForLocale(app()->getLocale()));
    </script>
</head>
<body class="bg-gray-50 min-h-screen">

    {{-- Toast --}}
    <div id="toast" class="toast-container fixed top-5 right-5 z-[9999] max-w-sm w-full hidden">
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-4 flex items-start gap-3">
            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                <i class="fas fa-check-circle text-lg text-green-500"></i>
            </div>
            <div class="flex-1 min-w-0 pt-0.5">
                <p id="toast-title" class="font-bold text-gray-800 text-sm"></p>
                <p id="toast-message" class="text-gray-500 text-xs mt-0.5"></p>
            </div>
            <button onclick="document.getElementById('toast').classList.remove('show')"
                class="text-gray-300 hover:text-gray-500 transition shrink-0 mt-0.5">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
    </div>

    @yield('content')

    @vite('resources/js/auth.js')
    @yield('scripts')
</body>
</html>
