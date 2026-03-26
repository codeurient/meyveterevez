@extends('layouts.guest')

@section('title', __t('auth.login'))
@section('description', __t('auth.login_subtitle'))

@section('content')
<div class="min-h-screen flex">

    {{-- ==================== LEFT BRAND PANEL (desktop only) ==================== --}}
    <div class="hidden lg:flex lg:w-[420px] xl:w-[480px] shrink-0 bg-gradient-to-br from-green-600 via-green-500 to-emerald-400 flex-col justify-between p-10 relative overflow-hidden">
        {{-- Background pattern --}}
        <div class="absolute inset-0 opacity-10"
             style="background-image: url('https://images.unsplash.com/photo-1542838132-92c53300491e?w=1200&q=40'); background-size: cover; background-position: center;"></div>

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="relative flex items-center gap-3">
            <div class="w-11 h-11 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center text-white text-xl shadow-lg">
                <i class="fas fa-shopping-basket"></i>
            </div>
            <span class="text-xl font-bold font-montserrat text-white tracking-tight">
                MeyveTerevez<span class="text-white/60">.</span>
            </span>
        </a>

        {{-- Middle content --}}
        <div class="relative">
            <h2 class="font-montserrat font-bold text-3xl text-white leading-tight mb-3">
                {{ __t('auth.brand_headline') }}
            </h2>
            <p class="text-green-100 text-sm leading-relaxed mb-8">
                {{ __t('auth.brand_sub') }}
            </p>
            <ul class="space-y-3">
                @foreach([
                    ['fas fa-truck',      'value_prop.fast_delivery',    'value_prop.fast_delivery_desc'],
                    ['fas fa-leaf',       'value_prop.fresh_organic',    'value_prop.fresh_organic_desc'],
                    ['fas fa-map-pin',    'value_prop.local_sellers',    'value_prop.local_sellers_desc'],
                    ['fas fa-money-bill', 'value_prop.cash_on_delivery', 'value_prop.cash_on_delivery_desc'],
                ] as [$icon, $title, $desc])
                    <li class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center text-white shrink-0">
                            <i class="{{ $icon }} text-xs"></i>
                        </div>
                        <div>
                            <p class="text-white font-semibold text-sm">{{ __t($title) }}</p>
                            <p class="text-green-100 text-xs">{{ __t($desc) }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Footer --}}
        <p class="relative text-green-200 text-xs">
            &copy; {{ date('Y') }} MeyveTerevez. {{ __t('footer.rights') }}
        </p>
    </div>

    {{-- ==================== RIGHT FORM PANEL ==================== --}}
    <div class="flex-1 flex flex-col justify-center items-center px-5 py-10 sm:px-10">

        {{-- Mobile logo --}}
        <a href="{{ route('home') }}" class="lg:hidden flex items-center gap-2 mb-8">
            <div class="w-9 h-9 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center text-white text-lg shadow-lg shadow-green-200">
                <i class="fas fa-shopping-basket"></i>
            </div>
            <span class="text-lg font-bold font-montserrat tracking-tight">
                MeyveTerevez<span class="text-green-500">.</span>
            </span>
        </a>

        <div class="w-full max-w-md">
            {{-- Heading --}}
            <div class="mb-7">
                <h1 class="font-montserrat font-bold text-2xl text-gray-800 mb-1">{{ __t('auth.welcome_back') }}</h1>
                <p class="text-gray-500 text-sm">{{ __t('auth.login_subtitle') }}</p>
            </div>

            {{-- Validation errors --}}
            @if($errors->any())
                <div class="mb-5 bg-red-50 border border-red-100 rounded-xl p-4">
                    <ul class="text-red-600 text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li class="flex items-center gap-2"><i class="fas fa-exclamation-circle text-xs"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Session status --}}
            @if(session('status'))
                <div class="mb-5 bg-green-50 border border-green-100 rounded-xl p-4 text-green-700 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-4" novalidate>
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-xs font-semibold text-gray-600 mb-1.5">
                        {{ __t('auth.email') }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400 text-xs"></i>
                        </div>
                        <input type="email" id="email" name="email"
                            value="{{ old('email') }}"
                            required autocomplete="email" autofocus
                            placeholder="{{ __t('auth.email_placeholder') }}"
                            class="w-full pl-9 pr-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition
                                   {{ $errors->has('email') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50 focus:bg-white' }}">
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-semibold text-gray-600">
                            {{ __t('auth.password') }}
                        </label>
                        <a href="#" class="text-xs text-green-600 hover:text-green-700 font-medium transition">
                            {{ __t('auth.forgot_password') }}
                        </a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400 text-xs"></i>
                        </div>
                        <input type="password" id="password" name="password"
                            required autocomplete="current-password"
                            placeholder="{{ __t('auth.password_placeholder') }}"
                            class="w-full pl-9 pr-10 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition
                                   {{ $errors->has('password') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50 focus:bg-white' }}">
                        <button type="button" id="togglePassword"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition">
                            <i class="fas fa-eye text-xs" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                {{-- Remember me --}}
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="remember" name="remember"
                        class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500 cursor-pointer">
                    <label for="remember" class="text-sm text-gray-600 cursor-pointer select-none">
                        {{ __t('auth.remember_me') }}
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full btn-primary flex items-center justify-center gap-2 py-2.5 mt-2">
                    <i class="fas fa-sign-in-alt text-sm"></i>
                    {{ __t('auth.sign_in') }}
                </button>
            </form>

            {{-- Divider --}}
            <div class="flex items-center gap-3 my-6">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-xs text-gray-400 font-medium">{{ __t('auth.or') }}</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            {{-- Register link --}}
            <p class="text-center text-sm text-gray-500">
                {{ __t('auth.no_account') }}
                <a href="{{ route('register') }}" class="text-green-600 hover:text-green-700 font-semibold transition">
                    {{ __t('auth.sign_up') }}
                </a>
            </p>
        </div>
    </div>
</div>
@endsection

