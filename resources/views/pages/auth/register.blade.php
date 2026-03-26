@extends('layouts.guest')

@section('title', __t('auth.register'))
@section('description', __t('auth.register_subtitle'))

@section('content')
<div class="min-h-screen flex">

    {{-- ==================== LEFT BRAND PANEL (desktop only) ==================== --}}
    <div class="hidden lg:flex lg:w-[420px] xl:w-[480px] shrink-0 bg-gradient-to-br from-green-600 via-green-500 to-emerald-400 flex-col justify-between p-10 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10"
             style="background-image: url('https://images.unsplash.com/photo-1488459716781-31db52582fe9?w=1200&q=40'); background-size: cover; background-position: center;"></div>

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
                {{ __t('auth.register_headline') }}
            </h2>
            <p class="text-green-100 text-sm leading-relaxed mb-8">
                {{ __t('auth.register_sub') }}
            </p>
            <ul class="space-y-3">
                @foreach([
                    ['fas fa-bolt',        'auth.perk_fast',    'auth.perk_fast_desc'],
                    ['fas fa-shield-alt',  'auth.perk_secure',  'auth.perk_secure_desc'],
                    ['fas fa-store',       'auth.perk_sellers', 'auth.perk_sellers_desc'],
                    ['fas fa-bell',        'auth.perk_offers',  'auth.perk_offers_desc'],
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
                <h1 class="font-montserrat font-bold text-2xl text-gray-800 mb-1">{{ __t('auth.create_account') }}</h1>
                <p class="text-gray-500 text-sm">{{ __t('auth.register_subtitle') }}</p>
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

            {{-- Form --}}
            <form method="POST" action="{{ route('register') }}" class="space-y-4" novalidate>
                @csrf

                {{-- First + Last name (2 columns) --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="first_name" class="block text-xs font-semibold text-gray-600 mb-1.5">
                            {{ __t('auth.first_name') }}
                        </label>
                        <input type="text" id="first_name" name="first_name"
                            value="{{ old('first_name') }}"
                            required autocomplete="given-name" autofocus
                            placeholder="{{ __t('auth.first_name_placeholder') }}"
                            class="w-full px-3.5 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition
                                   {{ $errors->has('first_name') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50 focus:bg-white' }}">
                    </div>
                    <div>
                        <label for="last_name" class="block text-xs font-semibold text-gray-600 mb-1.5">
                            {{ __t('auth.last_name') }}
                        </label>
                        <input type="text" id="last_name" name="last_name"
                            value="{{ old('last_name') }}"
                            required autocomplete="family-name"
                            placeholder="{{ __t('auth.last_name_placeholder') }}"
                            class="w-full px-3.5 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition
                                   {{ $errors->has('last_name') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50 focus:bg-white' }}">
                    </div>
                </div>

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
                            required autocomplete="email"
                            placeholder="{{ __t('auth.email_placeholder') }}"
                            class="w-full pl-9 pr-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition
                                   {{ $errors->has('email') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50 focus:bg-white' }}">
                    </div>
                </div>

                {{-- Phone (optional) --}}
                <div>
                    <label for="phone" class="block text-xs font-semibold text-gray-600 mb-1.5">
                        {{ __t('auth.phone') }}
                        <span class="text-gray-400 font-normal">({{ __t('label.optional') }})</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-phone text-gray-400 text-xs"></i>
                        </div>
                        <input type="tel" id="phone" name="phone"
                            value="{{ old('phone') }}"
                            autocomplete="tel"
                            placeholder="{{ __t('auth.phone_placeholder') }}"
                            class="w-full pl-9 pr-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition
                                   {{ $errors->has('phone') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50 focus:bg-white' }}">
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-xs font-semibold text-gray-600 mb-1.5">
                        {{ __t('auth.password') }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400 text-xs"></i>
                        </div>
                        <input type="password" id="password" name="password"
                            required autocomplete="new-password"
                            placeholder="{{ __t('auth.password_placeholder') }}"
                            class="w-full pl-9 pr-10 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition
                                   {{ $errors->has('password') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50 focus:bg-white' }}">
                        <button type="button" id="togglePassword"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition">
                            <i class="fas fa-eye text-xs" id="eyeIcon"></i>
                        </button>
                    </div>
                    {{-- Strength hint --}}
                    <div id="strengthBar" class="mt-1.5 h-1 rounded-full bg-gray-200 overflow-hidden hidden">
                        <div id="strengthFill" class="h-full rounded-full transition-all duration-300 w-0"></div>
                    </div>
                </div>

                {{-- Confirm password --}}
                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-gray-600 mb-1.5">
                        {{ __t('auth.confirm_password') }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400 text-xs"></i>
                        </div>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            required autocomplete="new-password"
                            placeholder="{{ __t('auth.confirm_password_placeholder') }}"
                            class="w-full pl-9 pr-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition
                                   {{ $errors->has('password_confirmation') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50 focus:bg-white' }}">
                    </div>
                </div>

                {{-- Terms --}}
                <p class="text-xs text-gray-400 leading-relaxed">
                    {{ __t('auth.agree_terms_prefix') }}
                    <a href="#" class="text-green-600 hover:underline">{{ __t('footer.terms') }}</a>
                    {{ __t('auth.agree_terms_and') }}
                    <a href="#" class="text-green-600 hover:underline">{{ __t('footer.privacy') }}</a>.
                </p>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full btn-primary flex items-center justify-center gap-2 py-2.5 mt-1">
                    <i class="fas fa-user-plus text-sm"></i>
                    {{ __t('auth.sign_up') }}
                </button>
            </form>

            {{-- Divider --}}
            <div class="flex items-center gap-3 my-6">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-xs text-gray-400 font-medium">{{ __t('auth.or') }}</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            {{-- Login link --}}
            <p class="text-center text-sm text-gray-500">
                {{ __t('auth.have_account') }}
                <a href="{{ route('login') }}" class="text-green-600 hover:text-green-700 font-semibold transition">
                    {{ __t('auth.sign_in') }}
                </a>
            </p>
        </div>
    </div>
</div>
@endsection

