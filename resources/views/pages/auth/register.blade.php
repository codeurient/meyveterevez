@extends('layouts.guest')

@section('title', __t('auth.register'))
@section('description', __t('auth.register_subtitle'))

@section('content')
<div class="min-h-screen flex">

    {{-- ==================== LEFT BRAND PANEL ==================== --}}
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
            <form method="POST" action="{{ route('register') }}" class="space-y-3" novalidate>
                @csrf

                {{-- First + Last name --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="first_name" class="block text-xs font-semibold text-gray-600 mb-1.5">
                            {{ __t('auth.first_name') }}
                        </label>
                        <input type="text" id="first_name" name="first_name"
                            value="{{ old('first_name') }}"
                            required autocomplete="given-name" autofocus
                            placeholder="{{ __t('auth.first_name_placeholder') }}"
                            class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition
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
                            class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition
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

                {{-- ── Phone — unified single-box component ── --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        {{ __t('auth.phone') }}
                        <span class="text-gray-400 font-normal ml-0.5">({{ __t('label.optional') }})</span>
                    </label>

                    <div class="relative" id="phonePickerWrapper">
                        <input type="hidden" name="phone_country_code" id="phoneCodeInput" value="{{ old('phone_country_code') }}">

                        {{-- Unified container: single border, no gaps --}}
                        <div id="phoneInputContainer"
                             class="flex items-stretch rounded-xl border overflow-hidden transition-all
                                    {{ $errors->has('phone') ? 'border-red-300 ring-1 ring-red-300' : 'border-gray-200' }}">

                            {{-- Country code trigger --}}
                            <button type="button" id="phonePickerTrigger"
                                    class="flex items-center gap-1.5 px-3 py-2.5 bg-gray-50 hover:bg-gray-100 border-r border-gray-200 transition shrink-0 min-w-[72px]">
                                <span id="phonePickerDialCode" class="text-gray-600 font-mono text-xs font-semibold whitespace-nowrap">+—</span>
                                <i class="fas fa-chevron-down text-gray-400 text-[9px] ml-auto transition-transform duration-200" id="phoneChevron"></i>
                            </button>

                            {{-- Phone number input --}}
                            <input type="tel" id="phoneNumberInput" name="phone"
                                value="{{ old('phone') }}"
                                autocomplete="tel"
                                placeholder="{{ __t('auth.phone_placeholder') }}"
                                class="flex-1 px-3 py-2.5 bg-white text-sm focus:outline-none text-gray-800 placeholder-gray-400 min-w-0">
                        </div>

                        {{-- Leading-zero warning --}}
                        <p id="phoneLeadingZeroWarning"
                           class="hidden mt-1.5 text-xs text-amber-600 flex items-center gap-1.5">
                            <i class="fas fa-exclamation-circle text-[10px]"></i>
                            <span>{{ __t('auth.phone_no_leading_zero') }}</span>
                        </p>

                        {{-- Phone picker dropdown --}}
                        <div id="phonePickerDropdown"
                             class="hidden absolute top-full left-0 mt-1.5 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden"
                             style="min-width: 260px; max-width: 320px; z-index: 9999;">
                            <div class="p-2.5 border-b border-gray-100">
                                <input type="text" id="phonePickerSearch"
                                       placeholder="{{ __t('auth.select_country') }}..."
                                       class="w-full px-3 py-1.5 bg-gray-50 text-xs rounded-xl border border-gray-200 focus:outline-none focus:border-green-500 text-gray-700 placeholder-gray-400">
                            </div>
                            <ul id="phonePickerList" class="overflow-y-auto py-1" style="max-height: 200px;"></ul>
                        </div>
                    </div>
                </div>

                {{-- ── Country + City — custom dropdowns ── --}}
                <div class="grid grid-cols-2 gap-3">

                    {{-- Country — label OUTSIDE relative wrapper --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                            {{ __t('auth.country') }}
                            <span class="text-gray-400 font-normal ml-0.5">({{ __t('label.optional') }})</span>
                        </label>
                        <div class="relative" id="countryPickerWrapper">
                            <input type="hidden" name="country_filter" id="countryPickerValue" value="{{ old('country_filter') }}">
                            <button type="button" id="countryPickerTrigger"
                                    class="w-full flex items-center justify-between gap-2 px-4 py-2.5 border border-gray-200 bg-gray-50 rounded-xl text-sm text-left focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition hover:bg-white">
                                <span id="countryPickerLabel" class="truncate text-gray-400 text-xs">{{ __t('auth.select_country') }}</span>
                                <i class="fas fa-chevron-down text-gray-400 text-[9px] shrink-0 transition-transform duration-200" id="countryChevron"></i>
                            </button>
                            <div id="countryPickerDropdown"
                                 class="hidden absolute top-full left-0 mt-1.5 w-full bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden"
                                 style="min-width: 180px; z-index: 9999;">
                                <div class="p-2.5 border-b border-gray-100">
                                    <input type="text" id="countryPickerSearch"
                                           placeholder="{{ __t('auth.select_country') }}..."
                                           class="w-full px-3 py-1.5 bg-gray-50 text-xs rounded-xl border border-gray-200 focus:outline-none focus:border-green-500 text-gray-700 placeholder-gray-400">
                                </div>
                                <ul id="countryPickerList" class="overflow-y-auto py-1" style="max-height: 180px;">
                                    <li data-id="" class="px-3 py-2 cursor-pointer text-gray-400 text-xs hover:bg-gray-50">{{ __t('auth.select_country') }}</li>
                                    @foreach($countries as $country)
                                        <li data-id="{{ $country->id }}" data-name="{{ $country->translated_name }}"
                                            class="px-3 py-2 cursor-pointer text-gray-700 text-xs transition-colors hover:bg-green-50 hover:text-green-700">
                                            {{ $country->translated_name }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- City — label OUTSIDE relative wrapper --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                            {{ __t('auth.city') }}
                            <span class="text-gray-400 font-normal ml-0.5">({{ __t('label.optional') }})</span>
                        </label>
                        <div class="relative" id="cityPickerWrapper">
                            <input type="hidden" name="location_id" id="cityPickerValue" value="{{ old('location_id') }}">
                            <button type="button" id="cityPickerTrigger"
                                    class="w-full flex items-center justify-between gap-2 px-4 py-2.5 border rounded-xl text-sm text-left focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition hover:bg-white
                                           {{ $errors->has('location_id') ? 'border-red-300 bg-red-50' : 'border-gray-200 bg-gray-50' }}">
                                <span id="cityPickerLabel" class="truncate text-gray-400 text-xs">{{ __t('auth.select_city') }}</span>
                                <i class="fas fa-chevron-down text-gray-400 text-[9px] shrink-0 transition-transform duration-200" id="cityChevron"></i>
                            </button>
                            <div id="cityPickerDropdown"
                                 class="hidden absolute top-full left-0 mt-1.5 w-full bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden"
                                 style="min-width: 180px; z-index: 9999;">
                                <div class="p-2.5 border-b border-gray-100">
                                    <input type="text" id="cityPickerSearch"
                                           placeholder="{{ __t('auth.select_city') }}..."
                                           class="w-full px-3 py-1.5 bg-gray-50 text-xs rounded-xl border border-gray-200 focus:outline-none focus:border-green-500 text-gray-700 placeholder-gray-400">
                                </div>
                                <ul id="cityPickerList" class="overflow-y-auto py-1" style="max-height: 180px;">
                                    {{-- Populated by JS --}}
                                </ul>
                            </div>
                        </div>
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
                    <div id="strengthBar" class="mt-1 h-0.5 rounded-full bg-gray-100 overflow-hidden hidden">
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
                <p class="text-xs text-gray-500 leading-relaxed">
                    {{ __t('auth.agree_terms_prefix') }}
                    <a href="#" class="text-green-600 hover:underline font-semibold">{{ __t('footer.terms') }}</a>
                    {{ __t('auth.agree_terms_and') }}
                    <a href="#" class="text-green-600 hover:underline font-semibold">{{ __t('footer.privacy') }}</a>.
                </p>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full btn-primary flex items-center justify-center gap-2 py-2.5 mt-2">
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

@section('scripts')
<script>
(function () {
    'use strict';

    // ── Helpers ───────────────────────────────────────────────────────────────
    function setChevron(el, open) {
        if (!el) return;
        el.style.transform = open ? 'rotate(180deg)' : '';
    }

    function closeAll(except) {
        if (except !== 'phone') {
            phoneDropdown.classList.add('hidden');
            setChevron(phoneChevronEl, false);
        }
        if (except !== 'country') {
            countryDropdown.classList.add('hidden');
            setChevron(countryChevronEl, false);
        }
        if (except !== 'city') {
            cityDropdown.classList.add('hidden');
            setChevron(cityChevronEl, false);
        }
    }

    // ── Phone code picker ─────────────────────────────────────────────────────
    var phoneCodes      = @json($phoneCodesJson);
    var phoneWrapper    = document.getElementById('phonePickerWrapper');
    var phoneTrigger    = document.getElementById('phonePickerTrigger');
    var phoneDropdown   = document.getElementById('phonePickerDropdown');
    var phoneSearch     = document.getElementById('phonePickerSearch');
    var phoneList       = document.getElementById('phonePickerList');
    var phoneHidden     = document.getElementById('phoneCodeInput');
    var phoneDial       = document.getElementById('phonePickerDialCode');
    var phoneContainer  = document.getElementById('phoneInputContainer');
    var phoneChevronEl  = document.getElementById('phoneChevron');

    function renderPhoneList(items) {
        phoneList.innerHTML = items.map(function (pc) {
            var isSelected = phoneHidden.value === pc.code;
            return '<li data-code="' + pc.code + '" data-dial="' + pc.phone_code + '"'
                 + ' class="flex items-center gap-2.5 px-3 py-2 cursor-pointer transition-colors text-xs'
                 + (isSelected ? ' bg-green-50 text-green-700 font-medium' : ' text-gray-700 hover:bg-green-50 hover:text-green-700') + '">'
                 + '<span class="flex-1 truncate">' + pc.name + '</span>'
                 + '<span class="font-mono text-[11px] shrink-0 ' + (isSelected ? 'text-green-600' : 'text-gray-400') + '">' + pc.phone_code + '</span>'
                 + '</li>';
        }).join('');
    }

    function selectPhoneCode(code, dial) {
        phoneHidden.value = code;
        phoneDial.textContent = dial;
        closeAll('none');
        phoneSearch.value = '';
        renderPhoneList(phoneCodes);
    }

    // Restore old value or default to AZ
    var defaultCode = phoneHidden.value || 'AZ';
    var foundDefault = phoneCodes.find(function (p) { return p.code === defaultCode; });
    if (!foundDefault && phoneCodes.length) foundDefault = phoneCodes[0];
    if (foundDefault) {
        phoneDial.textContent = foundDefault.phone_code;
        if (!phoneHidden.value) phoneHidden.value = foundDefault.code;
    }
    renderPhoneList(phoneCodes);

    phoneTrigger.addEventListener('click', function (e) {
        e.stopPropagation();
        var isOpen = !phoneDropdown.classList.contains('hidden');
        closeAll('phone');
        if (isOpen) {
            phoneDropdown.classList.add('hidden');
            setChevron(phoneChevronEl, false);
            return;
        }
        phoneDropdown.classList.remove('hidden');
        setChevron(phoneChevronEl, true);
        setTimeout(function () { phoneSearch.focus(); }, 30);
    });

    phoneSearch.addEventListener('input', function () {
        var q = this.value.toLowerCase();
        renderPhoneList(phoneCodes.filter(function (pc) {
            return pc.name.toLowerCase().includes(q)
                || pc.phone_code.includes(q)
                || pc.code.toLowerCase().includes(q);
        }));
    });

    phoneList.addEventListener('click', function (e) {
        var li = e.target.closest('li[data-code]');
        if (li) selectPhoneCode(li.dataset.code, li.dataset.dial);
    });

    // Focus ring on unified container
    var phoneTextInput = phoneContainer.querySelector('input[type="tel"]');
    [phoneTrigger, phoneTextInput].forEach(function (el) {
        el.addEventListener('focus', function () {
            phoneContainer.classList.add('ring-2', 'ring-green-500', 'border-transparent');
        });
        el.addEventListener('blur', function () {
            setTimeout(function () {
                if (!phoneContainer.contains(document.activeElement)) {
                    phoneContainer.classList.remove('ring-2', 'ring-green-500', 'border-transparent');
                }
            }, 100);
        });
    });

    // ── Leading-zero stripping ────────────────────────────────────────────────
    var phoneWarning       = document.getElementById('phoneLeadingZeroWarning');
    var phoneWarningTimer  = null;

    function showPhoneWarning() {
        if (!phoneWarning) return;
        phoneWarning.classList.remove('hidden');
        clearTimeout(phoneWarningTimer);
        phoneWarningTimer = setTimeout(function () {
            phoneWarning.classList.add('hidden');
        }, 3000);
    }

    phoneTextInput.addEventListener('input', function () {
        // Strip one or more leading zeros the moment the user types them
        if (/^0+/.test(this.value)) {
            this.value = this.value.replace(/^0+/, '');
            showPhoneWarning();
        } else if (phoneWarning) {
            phoneWarning.classList.add('hidden');
            clearTimeout(phoneWarningTimer);
        }
    });

    // Guard on form submit as a second safety net
    phoneTextInput.closest('form').addEventListener('submit', function () {
        if (/^0+/.test(phoneTextInput.value)) {
            phoneTextInput.value = phoneTextInput.value.replace(/^0+/, '');
        }
    });

    // ── Country picker ────────────────────────────────────────────────────────
    var countryWrapper    = document.getElementById('countryPickerWrapper');
    var countryTrigger    = document.getElementById('countryPickerTrigger');
    var countryDropdown   = document.getElementById('countryPickerDropdown');
    var countrySearch     = document.getElementById('countryPickerSearch');
    var countryList       = document.getElementById('countryPickerList');
    var countryHidden     = document.getElementById('countryPickerValue');
    var countryLabel      = document.getElementById('countryPickerLabel');
    var countryChevronEl  = document.getElementById('countryChevron');
    var selectedCountryId = countryHidden.value ? parseInt(countryHidden.value, 10) : null;

    var TXT_SELECT_COUNTRY = @json(__t('auth.select_country'));
    var TXT_SELECT_CITY    = @json(__t('auth.select_city'));

    // Restore old country label
    if (selectedCountryId) {
        var oldCLi = countryList.querySelector('li[data-id="' + selectedCountryId + '"]');
        if (oldCLi && oldCLi.dataset.id) {
            countryLabel.textContent = oldCLi.dataset.name || oldCLi.textContent.trim();
            countryLabel.classList.replace('text-gray-400', 'text-gray-700');
        }
    }

    countryTrigger.addEventListener('click', function (e) {
        e.stopPropagation();
        var isOpen = !countryDropdown.classList.contains('hidden');
        closeAll('country');
        if (isOpen) {
            countryDropdown.classList.add('hidden');
            setChevron(countryChevronEl, false);
            return;
        }
        countryDropdown.classList.remove('hidden');
        setChevron(countryChevronEl, true);
        setTimeout(function () { countrySearch.focus(); }, 30);
    });

    countrySearch.addEventListener('input', function () {
        var q = this.value.toLowerCase();
        Array.from(countryList.querySelectorAll('li[data-id]')).forEach(function (li) {
            if (!li.dataset.id) return;
            li.hidden = q ? !li.textContent.toLowerCase().includes(q) : false;
        });
    });

    countryList.addEventListener('click', function (e) {
        var li = e.target.closest('li[data-id]');
        if (!li) return;
        selectedCountryId = li.dataset.id ? parseInt(li.dataset.id, 10) : null;
        countryHidden.value = selectedCountryId || '';
        countryLabel.textContent = selectedCountryId ? (li.dataset.name || li.textContent.trim()) : TXT_SELECT_COUNTRY;
        countryLabel.className = 'truncate text-xs ' + (selectedCountryId ? 'text-gray-700' : 'text-gray-400');
        closeAll('none');
        countrySearch.value = '';
        Array.from(countryList.querySelectorAll('li')).forEach(function (l) { l.hidden = false; });
        // Reset city
        selectedCityId = null;
        cityHidden.value = '';
        cityLabel.textContent = TXT_SELECT_CITY;
        cityLabel.className = 'truncate text-xs text-gray-400';
        renderCityList('');
        updateCityTriggerState();
    });

    // ── City picker ───────────────────────────────────────────────────────────
    var cityWrapper    = document.getElementById('cityPickerWrapper');
    var cityTrigger    = document.getElementById('cityPickerTrigger');
    var cityDropdown   = document.getElementById('cityPickerDropdown');
    var citySearch     = document.getElementById('cityPickerSearch');
    var cityListEl     = document.getElementById('cityPickerList');
    var cityHidden     = document.getElementById('cityPickerValue');
    var cityLabel      = document.getElementById('cityPickerLabel');
    var cityChevronEl  = document.getElementById('cityChevron');
    var selectedCityId = cityHidden.value ? parseInt(cityHidden.value, 10) : null;

    var cityData = @json($cities->map(fn($c) => ['id' => $c->id, 'name' => $c->translated_name, 'parent_id' => $c->parent_id]));

    function renderCityList(searchQ) {
        if (!selectedCountryId) {
            cityListEl.innerHTML = '<li class="px-3 py-3 text-gray-400 text-xs text-center">'
                + TXT_SELECT_COUNTRY + '</li>';
            return;
        }
        var items = cityData.filter(function (c) {
            var matchParent = c.parent_id === selectedCountryId;
            var matchSearch = searchQ ? c.name.toLowerCase().includes(searchQ.toLowerCase()) : true;
            return matchParent && matchSearch;
        });
        cityListEl.innerHTML = '<li data-id="" class="px-3 py-2 cursor-pointer text-gray-400 text-xs hover:bg-gray-50">'
            + TXT_SELECT_CITY + '</li>'
            + items.map(function (c) {
                var active = selectedCityId === c.id;
                return '<li data-id="' + c.id + '" data-name="' + c.name.replace(/&/g,'&amp;').replace(/"/g,'&quot;') + '"'
                     + ' class="px-3 py-2 cursor-pointer text-xs transition-colors '
                     + (active ? 'bg-green-50 text-green-700 font-medium' : 'text-gray-700 hover:bg-green-50 hover:text-green-700') + '">'
                     + c.name + '</li>';
            }).join('');
    }

    // Restore old city label
    if (selectedCityId) {
        var oldCity = cityData.find(function (c) { return c.id === selectedCityId; });
        if (oldCity) {
            cityLabel.textContent = oldCity.name;
            cityLabel.classList.replace('text-gray-400', 'text-gray-700');
            if (!selectedCountryId) {
                selectedCountryId = oldCity.parent_id || null;
                countryHidden.value = selectedCountryId || '';
                if (selectedCountryId) {
                    var parentLi = countryList.querySelector('li[data-id="' + selectedCountryId + '"]');
                    if (parentLi) {
                        countryLabel.textContent = parentLi.dataset.name || parentLi.textContent.trim();
                        countryLabel.className = 'truncate text-xs text-gray-700';
                    }
                }
            }
        }
    }
    renderCityList('');

    function updateCityTriggerState() {
        if (selectedCountryId) {
            cityTrigger.disabled = false;
            cityTrigger.classList.remove('opacity-50', 'cursor-not-allowed');
            cityTrigger.classList.add('hover:bg-white');
        } else {
            cityTrigger.disabled = true;
            cityTrigger.classList.add('opacity-50', 'cursor-not-allowed');
            cityTrigger.classList.remove('hover:bg-white');
        }
    }
    updateCityTriggerState();

    cityTrigger.addEventListener('click', function (e) {
        e.stopPropagation();
        if (!selectedCountryId) return;
        var isOpen = !cityDropdown.classList.contains('hidden');
        closeAll('city');
        if (isOpen) {
            cityDropdown.classList.add('hidden');
            setChevron(cityChevronEl, false);
            return;
        }
        cityDropdown.classList.remove('hidden');
        setChevron(cityChevronEl, true);
        setTimeout(function () { citySearch.focus(); }, 30);
    });

    citySearch.addEventListener('input', function () {
        renderCityList(this.value);
    });

    cityListEl.addEventListener('click', function (e) {
        var li = e.target.closest('li[data-id]');
        if (!li) return;
        selectedCityId = li.dataset.id ? parseInt(li.dataset.id, 10) : null;
        cityHidden.value = selectedCityId || '';
        cityLabel.textContent = selectedCityId ? (li.dataset.name || li.textContent.trim()) : TXT_SELECT_CITY;
        cityLabel.className = 'truncate text-xs ' + (selectedCityId ? 'text-gray-700' : 'text-gray-400');
        closeAll('none');
        citySearch.value = '';
        renderCityList('');
    });

    // ── Global outside-click ──────────────────────────────────────────────────
    document.addEventListener('click', function (e) {
        if (!phoneWrapper.contains(e.target)) {
            phoneDropdown.classList.add('hidden');
            setChevron(phoneChevronEl, false);
        }
        if (!countryWrapper.contains(e.target)) {
            countryDropdown.classList.add('hidden');
            setChevron(countryChevronEl, false);
        }
        if (!cityWrapper.contains(e.target)) {
            cityDropdown.classList.add('hidden');
            setChevron(cityChevronEl, false);
        }
    });

    // ── Password toggle + strength ────────────────────────────────────────────
    var toggleBtn = document.getElementById('togglePassword');
    var pwInput   = document.getElementById('password');
    var eyeIcon   = document.getElementById('eyeIcon');
    var bar       = document.getElementById('strengthBar');
    var fill      = document.getElementById('strengthFill');

    if (toggleBtn && pwInput) {
        toggleBtn.addEventListener('click', function () {
            var isText = pwInput.type === 'text';
            pwInput.type = isText ? 'password' : 'text';
            eyeIcon.className = isText ? 'fas fa-eye text-xs' : 'fas fa-eye-slash text-xs';
        });

        pwInput.addEventListener('input', function () {
            var v = this.value;
            if (!v) { bar.classList.add('hidden'); return; }
            bar.classList.remove('hidden');
            var score = [/.{8,}/, /[A-Z]/, /[0-9]/, /[^A-Za-z0-9]/]
                .filter(function (r) { return r.test(v); }).length;
            var colors = ['bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-green-500'];
            var widths = ['w-1/4', 'w-2/4', 'w-3/4', 'w-full'];
            var idx = Math.max(0, score - 1);
            fill.className = 'h-full rounded-full transition-all duration-300 ' + colors[idx] + ' ' + widths[idx];
        });
    }

}());
</script>
@endsection
