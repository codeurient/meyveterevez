<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __t('admin.panel')) — Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans text-sm text-gray-800 min-h-screen">

{{-- ==================== SIDEBAR ==================== --}}
<div class="flex min-h-screen">
    <aside class="w-56 shrink-0 bg-gray-900 text-gray-300 flex flex-col min-h-screen fixed top-0 left-0 z-30">

        {{-- Logo --}}
        <div class="flex items-center gap-2.5 px-4 py-4 border-b border-gray-700/50">
            <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center text-white shrink-0">
                <i class="fas fa-leaf text-xs"></i>
            </div>
            <span class="font-montserrat font-bold text-white text-sm tracking-tight">
                MeyveTerevez
                <span class="block text-xs font-normal text-gray-400 leading-none">Admin Panel</span>
            </span>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 py-3 overflow-y-auto">
            <div class="px-3 mb-1">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5 px-2">{{ __t('admin.nav_general') }}</p>
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-2.5 px-2 py-2 rounded-lg text-xs font-medium transition
                          {{ request()->routeIs('admin.dashboard') ? 'bg-green-600/20 text-green-400' : 'hover:bg-gray-700/50 text-gray-300' }}">
                    <i class="fas fa-tachometer-alt w-4 text-center"></i>
                    {{ __t('admin.nav_dashboard') }}
                </a>
            </div>

            <div class="px-3 mt-3 mb-1">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5 px-2">{{ __t('admin.nav_catalog') }}</p>
                <a href="{{ route('admin.locations.index') }}"
                   class="flex items-center gap-2.5 px-2 py-2 rounded-lg text-xs font-medium transition
                          {{ request()->routeIs('admin.locations.*') ? 'bg-green-600/20 text-green-400' : 'hover:bg-gray-700/50 text-gray-300' }}">
                    <i class="fas fa-map-marker-alt w-4 text-center"></i>
                    {{ __t('admin.nav_locations') }}
                </a>
                <a href="{{ route('admin.phone-codes.index') }}"
                   class="flex items-center gap-2.5 px-2 py-2 rounded-lg text-xs font-medium transition
                          {{ request()->routeIs('admin.phone-codes.*') ? 'bg-green-600/20 text-green-400' : 'hover:bg-gray-700/50 text-gray-300' }}">
                    <i class="fas fa-phone w-4 text-center"></i>
                    {{ __t('admin.nav_phone_codes') }}
                </a>
            </div>
        </nav>

        {{-- User info + logout --}}
        <div class="px-3 py-3 border-t border-gray-700/50">
            <div class="flex items-center gap-2 px-2 py-1.5 mb-1.5">
                <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                     class="w-7 h-7 rounded-full object-cover shrink-0">
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-2 px-2 py-1.5 rounded-lg text-xs text-gray-400 hover:text-red-400 hover:bg-gray-700/50 transition">
                    <i class="fas fa-sign-out-alt w-4 text-center"></i>
                    {{ __t('auth.sign_out') }}
                </button>
            </form>
        </div>
    </aside>

    {{-- ==================== MAIN CONTENT ==================== --}}
    <div class="flex-1 ml-56 flex flex-col min-h-screen">

        {{-- Top bar --}}
        <header class="sticky top-0 z-20 bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between">
            <div>
                <h1 class="font-semibold text-gray-800 text-sm">@yield('title', __t('admin.panel'))</h1>
                @hasSection('breadcrumb')
                    <p class="text-xs text-gray-400 mt-0.5">@yield('breadcrumb')</p>
                @endif
            </div>
            <a href="{{ route('home') }}" target="_blank"
               class="text-xs text-gray-400 hover:text-gray-600 flex items-center gap-1.5 transition">
                <i class="fas fa-external-link-alt text-xs"></i>
                {{ __t('admin.view_site') }}
            </a>
        </header>

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="mx-6 mt-4 bg-green-50 border border-green-100 rounded-xl px-4 py-3 text-green-700 text-xs flex items-center gap-2">
                <i class="fas fa-check-circle text-green-500"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mx-6 mt-4 bg-red-50 border border-red-100 rounded-xl px-4 py-3">
                <ul class="text-red-600 text-xs space-y-1">
                    @foreach($errors->all() as $error)
                        <li class="flex items-center gap-2"><i class="fas fa-exclamation-circle text-xs"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Page content --}}
        <main class="flex-1 px-6 py-5">
            @yield('content')
        </main>

        <footer class="px-6 py-3 border-t border-gray-200 text-xs text-gray-400">
            &copy; {{ date('Y') }} MeyveTerevez Admin Panel
        </footer>
    </div>
</div>

@vite('resources/js/admin.js')
@yield('scripts')
</body>
</html>
