<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name')) — {{ config('app.name') }}</title>
    <meta name="description" content="@yield('description', 'Fresh fruits, vegetables and more — delivered to your door.')">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Vite: CSS + JS (Tailwind is compiled here) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- App URLs for JS (avoids hardcoded paths) --}}
    <script>
        window.Routes = {
            home:           "{{ route('home') }}",
            products:       "{{ route('products.index') }}",
            productsSearch: "{{ route('products.search') }}",
        };
    </script>

    @yield('head')
</head>
<body class="antialiased">

    {{-- ==================== TOAST NOTIFICATION ==================== --}}
    <div id="toast" class="toast fixed top-24 right-6 z-50 bg-white rounded-xl shadow-2xl p-4 flex items-center gap-3 min-w-[300px]">
        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
            <i class="fas fa-check-circle text-green-500 text-lg"></i>
        </div>
        <div>
            <h4 id="toast-title" class="font-bold text-gray-800">Success!</h4>
            <p id="toast-message" class="text-sm text-gray-600">Done.</p>
        </div>
    </div>

    {{-- ==================== HEADER ==================== --}}
    <header class="glass-header sticky top-0 z-50">

        {{-- Top Bar (desktop only) --}}
        <div class="bg-dark text-white py-2 hidden lg:block">
            <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center text-sm">
                <div class="flex items-center gap-6">
                    <span><i class="fas fa-phone-alt mr-2"></i>+994 XX XXX XX XX</span>
                    <span><i class="fas fa-envelope mr-2"></i>info@meyveterevez.az</span>
                </div>
                <div class="flex items-center gap-6">
                    <a href="#" class="hover:text-green-400 transition"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="hover:text-green-400 transition"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="hover:text-green-400 transition"><i class="fab fa-youtube"></i></a>
                    <div class="w-px h-4 bg-gray-600"></div>
                    <select id="langSelect"
                        class="bg-transparent border border-gray-600 text-white text-xs rounded-lg px-2 py-1 focus:outline-none focus:border-green-400 cursor-pointer appearance-none"
                        style="background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%239ca3af'/%3E%3C/svg%3E\"); background-repeat: no-repeat; background-position: right 6px center;">
                        @foreach($activeLocales as $loc)
                            <option value="{{ $loc->code }}"
                                {{ $currentLocale === $loc->code ? 'selected' : '' }}
                                style="background:#1f2937; color:#fff;">
                                {{ strtoupper($loc->code) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Main Header Row --}}
        <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center text-white text-xl lg:text-2xl shadow-lg shadow-green-200">
                        <i class="fas fa-shopping-basket"></i>
                    </div>
                    <span class="text-xl lg:text-2xl font-bold font-montserrat tracking-tight">
                        MeyveTerevez<span class="text-green-500">.</span>
                    </span>
                </a>

                {{-- Search Bar (desktop) --}}
                <div class="hidden md:block flex-1 max-w-2xl mx-8">
                    <form action="{{ route('products.search') }}" method="GET" class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400 group-focus-within:text-green-500 transition"></i>
                        </div>
                        <input type="text" name="q" id="mainSearch"
                            value="{{ request('q') }}"
                            placeholder="{{ __t('label.search_placeholder') }}"
                            class="w-full bg-gray-100 border-2 border-transparent rounded-2xl py-3 pl-12 pr-14 focus:border-green-500 focus:bg-white transition-all shadow-sm text-sm lg:text-base">
                        {{-- Filter Icon Button --}}
                        <div class="absolute inset-y-0 right-0 flex items-center pr-1">
                            <button type="button" id="searchFilterBtn" title="{{ __t('label.filters') }}"
                                class="search-filter-btn h-9 w-9 rounded-xl hover:bg-green-50 ml-1">
                                <i class="fas fa-sliders-h text-sm"></i>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Right Actions --}}
                <div class="flex items-center gap-2 lg:gap-4">

                    {{-- Account --}}
                    @auth
                        <div class="dropdown relative hidden lg:block">
                            <button class="flex items-center gap-2 text-gray-600 hover:text-green-600 font-semibold text-sm transition-colors py-2">
                                <i class="fas fa-user-circle text-lg"></i>
                                <span>{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div class="dropdown-menu absolute top-full right-0 mt-2 bg-white rounded-xl shadow-xl border border-gray-100 py-2 min-w-[200px]">
                                <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 transition">
                                    <i class="fas fa-user"></i> {{ __t('nav.my_profile') }}
                                </a>
                                <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 transition">
                                    <i class="fas fa-box"></i> {{ __t('nav.my_orders') }}
                                </a>
                                <a href="{{ route('favorites.index') }}" class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 transition">
                                    <i class="fas fa-heart"></i> {{ __t('nav.favorites') }}
                                </a>
                                <hr class="my-2 border-gray-100">
                                <a href="{{ route('stores.create') }}" class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 transition">
                                    <i class="fas fa-store"></i> {{ __t('nav.my_stores') }}
                                </a>
                                <hr class="my-2 border-gray-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-red-600 hover:bg-red-50 transition">
                                        <i class="fas fa-sign-out-alt"></i> {{ __t('nav.sign_out') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="hidden lg:flex items-center gap-2 text-gray-600 hover:text-green-600 font-semibold text-sm transition-colors">
                            <i class="fas fa-user-circle text-lg"></i>
                            <span>{{ __t('nav.sign_in') }}</span>
                        </a>
                    @endauth

                    {{-- Favorites --}}
                    <a href="{{ route('favorites.index') }}" class="relative p-2 lg:p-3 text-gray-600 hover:bg-green-50 hover:text-green-600 rounded-full transition-colors">
                        <i class="fas fa-heart text-lg"></i>
                        <span id="favCount" class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full items-center justify-center hidden">0</span>
                    </a>

                    {{-- Cart Button --}}
                    <button id="cartButton" onclick="openCart()" class="relative p-2 lg:p-3 text-gray-600 hover:bg-green-50 hover:text-green-600 rounded-full transition-colors">
                        <i class="fas fa-shopping-cart text-lg"></i>
                        <span id="cartCount" class="absolute -top-1 -right-1 w-5 h-5 bg-green-500 text-white text-xs font-bold rounded-full flex items-center justify-center">0</span>
                    </button>

                    {{-- Mobile Menu Button --}}
                    <button id="mobileMenuBtn" class="lg:hidden p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            {{-- Mobile Search --}}
            <div class="md:hidden pb-4">
                <form action="{{ route('products.search') }}" method="GET" class="relative">
                    <input type="text" name="q" placeholder="{{ __t('label.search_mobile_placeholder') }}"
                        class="w-full bg-gray-100 border-2 border-transparent rounded-xl py-2.5 pl-10 pr-11 text-sm focus:border-green-500">
                    <i class="fas fa-search absolute left-3.5 top-3 text-gray-400 pointer-events-none"></i>
                    <button type="button" title="{{ __t('label.filters') }}"
                        class="mobile-search-filter-btn absolute right-2 top-1/2 -translate-y-1/2 w-7 h-7 flex items-center justify-center text-gray-500 hover:text-green-600 transition">
                        <i class="fas fa-sliders-h text-sm"></i>
                    </button>
                </form>
            </div>

            {{-- Navigation (desktop) --}}
            <nav class="hidden lg:flex items-center gap-8 pb-4">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-green-600' : 'text-gray-700' }} font-semibold hover:text-green-600 flex items-center gap-2 transition">
                    <i class="fas fa-home"></i> {{ __t('nav.home') }}
                </a>
                <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'text-green-600' : 'text-gray-700' }} font-semibold hover:text-green-600 flex items-center gap-2 transition">
                    <i class="fas fa-th"></i> {{ __t('nav.categories') }}
                </a>
                <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'text-green-600' : 'text-gray-700' }} font-semibold hover:text-green-600 transition">
                    <i class="fas fa-apple-alt"></i> {{ __t('nav.products') }}
                </a>
                <a href="{{ route('stores.index') }}" class="{{ request()->routeIs('stores.*') ? 'text-green-600' : 'text-gray-700' }} font-semibold hover:text-green-600 transition">
                    <i class="fas fa-store"></i> {{ __t('nav.stores') }}
                </a>
                <a href="{{ route('map') }}" class="{{ request()->routeIs('map') ? 'text-green-600' : 'text-gray-700' }} font-semibold hover:text-green-600 transition">
                    <i class="fas fa-map-marked-alt"></i> {{ __t('nav.map') }}
                </a>
            </nav>
        </div>
    </header>

    {{-- ==================== MOBILE MENU ==================== --}}
    <div id="mobileMenu" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/50" id="mobileMenuOverlay"></div>
        <div class="absolute right-0 top-0 h-full w-80 bg-white shadow-2xl transform translate-x-full transition-transform duration-300" id="mobileMenuPanel">
            <div class="p-4 border-b flex items-center justify-between">
                <span class="font-bold text-lg">{{ __t('nav.menu') }}</span>
                <button id="closeMobileMenu" class="p-2 hover:bg-gray-100 rounded-lg">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="p-4 space-y-1">
                <a href="{{ route('home') }}"       class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-green-50 text-gray-700 hover:text-green-600 font-semibold transition"><i class="fas fa-home w-5"></i> {{ __t('nav.home') }}</a>
                <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-green-50 text-gray-700 hover:text-green-600 font-semibold transition"><i class="fas fa-th w-5"></i> {{ __t('nav.categories') }}</a>
                <a href="{{ route('products.index') }}"   class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-green-50 text-gray-700 hover:text-green-600 font-semibold transition"><i class="fas fa-apple-alt w-5"></i> {{ __t('nav.products') }}</a>
                <a href="{{ route('stores.index') }}"     class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-green-50 text-gray-700 hover:text-green-600 font-semibold transition"><i class="fas fa-store w-5"></i> {{ __t('nav.stores') }}</a>
                <a href="{{ route('map') }}"              class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-green-50 text-gray-700 hover:text-green-600 font-semibold transition"><i class="fas fa-map-marked-alt w-5"></i> {{ __t('nav.map') }}</a>
                <hr class="my-2">
                @auth
                    <a href="{{ route('profile') }}"       class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-green-50 text-gray-700 font-semibold transition"><i class="fas fa-user w-5"></i> {{ __t('nav.my_profile') }}</a>
                    <a href="{{ route('orders.index') }}"  class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-green-50 text-gray-700 font-semibold transition"><i class="fas fa-box w-5"></i> {{ __t('nav.my_orders') }}</a>
                    <a href="{{ route('stores.create') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-green-50 text-gray-700 font-semibold transition"><i class="fas fa-store w-5"></i> {{ __t('nav.my_stores') }}</a>
                @else
                    <a href="{{ route('login') }}"    class="flex items-center gap-3 px-3 py-3 rounded-xl bg-green-500 text-white font-semibold transition"><i class="fas fa-sign-in-alt w-5"></i> {{ __t('nav.sign_in') }}</a>
                    <a href="{{ route('register') }}" class="flex items-center gap-3 px-3 py-3 rounded-xl border-2 border-green-500 text-green-600 font-semibold transition"><i class="fas fa-user-plus w-5"></i> {{ __t('nav.register') }}</a>
                @endauth
                <hr class="my-2">
                {{-- Language switcher in mobile menu --}}
                <div class="flex items-center gap-2 px-3 py-2">
                    <span class="text-xs text-gray-500">{{ __t('nav.language') }}:</span>
                    @foreach($activeLocales as $loc)
                        <a href="?lang={{ $loc->code }}"
                           class="px-2 py-1 text-xs rounded font-semibold transition
                                  {{ $currentLocale === $loc->code ? 'bg-green-500 text-white' : 'text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                            {{ $loc->flag }} {{ strtoupper($loc->code) }}
                        </a>
                    @endforeach
                </div>
            </nav>
        </div>
    </div>

    {{-- ==================== MAIN CONTENT ==================== --}}
    <main>
        @yield('content')
    </main>

    {{-- ==================== FOOTER ==================== --}}
    <footer class="bg-gray-900 text-gray-300 pt-16 pb-8">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 mb-12">

                {{-- Company --}}
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center text-white text-xl">
                            <i class="fas fa-shopping-basket"></i>
                        </div>
                        <span class="text-xl font-bold text-white">MeyveTerevez<span class="text-green-500">.</span></span>
                    </div>
                    <p class="text-gray-400 mb-6 max-w-sm">{{ __t('footer.company_desc') }}</p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-green-500 rounded-full flex items-center justify-center transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-green-500 rounded-full flex items-center justify-center transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-green-500 rounded-full flex items-center justify-center transition"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h4 class="font-bold text-white mb-4">{{ __t('footer.quick_links') }}</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}"           class="hover:text-green-400 transition">{{ __t('nav.home') }}</a></li>
                        <li><a href="{{ route('products.index') }}" class="hover:text-green-400 transition">{{ __t('nav.products') }}</a></li>
                        <li><a href="{{ route('stores.index') }}"   class="hover:text-green-400 transition">{{ __t('nav.stores') }}</a></li>
                        <li><a href="{{ route('map') }}"            class="hover:text-green-400 transition">{{ __t('nav.map') }}</a></li>
                    </ul>
                </div>

                {{-- Customer Service --}}
                <div>
                    <h4 class="font-bold text-white mb-4">{{ __t('footer.customer_service') }}</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-green-400 transition">{{ __t('footer.help_center') }}</a></li>
                        <li><a href="#" class="hover:text-green-400 transition">{{ __t('footer.track_order') }}</a></li>
                        <li><a href="#" class="hover:text-green-400 transition">{{ __t('footer.faq') }}</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h4 class="font-bold text-white mb-4">{{ __t('footer.contact') }}</h4>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center gap-3"><i class="fas fa-envelope text-green-500"></i> info@meyveterevez.az</li>
                        <li class="flex items-center gap-3"><i class="fas fa-phone-alt text-green-500"></i> +994 XX XXX XX XX</li>
                    </ul>
                </div>
            </div>

            {{-- Bottom --}}
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} MeyveTerevez. {{ __t('footer.rights') }}</p>
                <div class="flex items-center gap-6">
                    <a href="#" class="text-gray-500 hover:text-white text-sm transition">{{ __t('footer.privacy') }}</a>
                    <a href="#" class="text-gray-500 hover:text-white text-sm transition">{{ __t('footer.terms') }}</a>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-gray-500 text-sm">{{ __t('footer.payment_label') }}:</span>
                    <span class="px-3 py-1 bg-gray-800 rounded text-xs text-green-400 font-semibold">
                        <i class="fas fa-money-bill-wave mr-1"></i> {{ __t('value_prop.cash_on_delivery') }}
                    </span>
                </div>
            </div>
        </div>
    </footer>

    {{-- ==================== CART SIDEBAR ==================== --}}
    <div class="cart-overlay fixed inset-0 bg-black/50 z-50" id="cartOverlay"></div>
    <div class="cart-sidebar fixed top-0 right-0 h-full w-full md:w-[420px] bg-white z-50 shadow-2xl flex flex-col" id="cartSidebar">
        <div class="flex items-center justify-between p-4 border-b">
            <h3 class="font-bold text-xl"><i class="fas fa-shopping-cart text-green-500 mr-2"></i>{{ __t('cart.title') }}</h3>
            <button id="closeCart" class="p-2 hover:bg-gray-100 rounded-lg transition">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto p-4" id="cartItems">
            <p class="text-gray-400 text-center py-12"><i class="fas fa-shopping-basket text-4xl mb-3 block"></i>{{ __t('cart.empty') }}</p>
        </div>
        <div class="border-t p-4 bg-gray-50">
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">{{ __t('cart.subtotal') }}</span>
                <span class="font-bold text-xl" id="cartSubtotal">₼0.00</span>
            </div>
            <div class="flex justify-between items-center mb-4 text-lg">
                <span class="font-bold">{{ __t('cart.total') }}</span>
                <span class="font-bold text-green-600 text-2xl" id="cartTotal">₼0.00</span>
            </div>
            <p class="text-xs text-gray-500 mb-3 text-center"><i class="fas fa-money-bill-wave text-green-500 mr-1"></i>{{ __t('cart.payment_note') }}</p>
            <a href="{{ route('checkout') }}" class="btn-primary w-full text-center block mb-3">
                {{ __t('button.checkout') }} <i class="fas fa-arrow-right ml-2"></i>
            </a>
            <button class="btn-secondary w-full" id="continueShopping">
                {{ __t('button.continue_shopping') }}
            </button>
        </div>
    </div>

    {{-- ==================== SEARCH FILTER OFFCANVAS (left) ==================== --}}
    <div class="search-filter-overlay fixed inset-0 bg-black/50 z-50" id="searchFilterOverlay"></div>
    <div class="search-filter-offcanvas fixed top-0 left-0 h-full w-80 max-w-[90vw] bg-white z-50 shadow-2xl flex flex-col" id="searchFilterOffcanvas">

        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-sliders-h text-green-500"></i> {{ __t('label.filters') }}
            </h3>
            <button id="closeSearchFilter" class="w-8 h-8 flex items-center justify-center hover:bg-gray-100 rounded-lg transition text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Scrollable body --}}
        <div class="flex-1 overflow-y-auto p-5 space-y-5">

            {{-- Category --}}
            <div class="pb-5 border-b border-gray-100">
                <h4 class="font-semibold text-sm text-gray-700 mb-3">{{ __t('label.category') }}</h4>
                <div class="flex flex-wrap gap-2">
                    <button class="filter-chip selected" data-cat="all">{{ __t('label.all') }}</button>
                    <button class="filter-chip" data-cat="fruits">🍎 {{ __t('filter.fruits') }}</button>
                    <button class="filter-chip" data-cat="vegetables">🥦 {{ __t('filter.vegetables') }}</button>
                    <button class="filter-chip" data-cat="dairy">🥛 {{ __t('filter.dairy') }}</button>
                    <button class="filter-chip" data-cat="bakery">🍞 {{ __t('filter.bakery') }}</button>
                    <button class="filter-chip" data-cat="meat">🥩 {{ __t('filter.meat') }}</button>
                    <button class="filter-chip" data-cat="beverages">🧃 {{ __t('filter.beverages') }}</button>
                </div>
            </div>

            {{-- Price Range --}}
            <div class="pb-5 border-b border-gray-100">
                <h4 class="font-semibold text-sm text-gray-700 mb-3">{{ __t('label.price_range') }}</h4>
                <div class="flex items-center gap-3">
                    <input type="number" placeholder="Min" min="0" value="0"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-green-500 focus:outline-none">
                    <span class="text-gray-400 shrink-0">—</span>
                    <input type="number" placeholder="Max" min="0" value="100"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-green-500 focus:outline-none">
                </div>
            </div>

            {{-- Rating --}}
            <div class="pb-5 border-b border-gray-100">
                <h4 class="font-semibold text-sm text-gray-700 mb-3">{{ __t('label.rating') }}</h4>
                <div class="space-y-2">
                    @foreach([5,4,3,2] as $stars)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="sf_rating" value="{{ $stars }}" class="accent-green-500">
                        <span class="text-yellow-400 text-sm leading-none">
                            @for($i=0;$i<$stars;$i++)<i class="fas fa-star text-xs"></i>@endfor
                        </span>
                        <span class="text-sm text-gray-600">{{ __t('label.and_up') }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Attributes --}}
            <div>
                <h4 class="font-semibold text-sm text-gray-700 mb-3">{{ __t('label.attributes') }}</h4>
                <div class="space-y-2">
                    <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                        <input type="checkbox" class="accent-green-500 w-4 h-4"> {{ __t('label.organic') }}
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                        <input type="checkbox" class="accent-green-500 w-4 h-4"> {{ __t('label.fresh_today') }}
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                        <input type="checkbox" class="accent-green-500 w-4 h-4"> {{ __t('label.in_stock_only') }}
                    </label>
                </div>
            </div>
        </div>

        {{-- Footer Buttons --}}
        <div class="border-t border-gray-100 p-4 flex gap-3 bg-white">
            <button id="resetSearchFilter" class="btn-secondary flex-1 py-2.5 text-sm">{{ __t('button.reset') }}</button>
            <button id="applySearchFilter" class="btn-primary flex-1 py-2.5 text-sm">{{ __t('button.apply') }}</button>
        </div>
    </div>

    {{-- ==================== FLOATING CART (mobile) ==================== --}}
    <button id="floatingCart" class="floating-cart md:hidden w-14 h-14 bg-green-500 rounded-full flex items-center justify-center text-white shadow-lg hover:bg-green-600 transition" onclick="openCart()">
        <i class="fas fa-shopping-cart text-xl"></i>
        <span id="floatingCartCount" class="absolute -top-1 -right-1 w-6 h-6 bg-red-500 text-white text-sm font-bold rounded-full items-center justify-center hidden">0</span>
    </button>

    {{-- ==================== LANGUAGE SELECT SCRIPT ==================== --}}
    <script>
    document.getElementById('langSelect')?.addEventListener('change', function () {
        const url = new URL(window.location.href);
        url.searchParams.set('lang', this.value);
        window.location.href = url.toString();
    });
    </script>

    {{-- ==================== SEARCH FILTER OFFCANVAS SCRIPT ==================== --}}
    <script>
    (function () {
        const offcanvas = document.getElementById('searchFilterOffcanvas');
        const overlay   = document.getElementById('searchFilterOverlay');

        function openSearchFilter() {
            offcanvas.classList.add('open');
            overlay.classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        window.openSearchFilter = openSearchFilter;

        function closeSearchFilter() {
            offcanvas.classList.remove('open');
            overlay.classList.remove('open');
            document.body.style.overflow = '';
        }

        // Desktop filter button (inside search bar)
        document.getElementById('searchFilterBtn')?.addEventListener('click', openSearchFilter);

        // Mobile filter button (inside mobile search bar)
        document.querySelectorAll('.mobile-search-filter-btn').forEach(btn =>
            btn.addEventListener('click', openSearchFilter)
        );

        // Close buttons
        document.getElementById('closeSearchFilter')?.addEventListener('click', closeSearchFilter);
        document.getElementById('applySearchFilter')?.addEventListener('click', closeSearchFilter);
        document.getElementById('resetSearchFilter')?.addEventListener('click', function () {
            offcanvas.querySelectorAll('input[type=number]').forEach((el, i) => el.value = i === 0 ? 0 : 100);
            offcanvas.querySelectorAll('input[type=radio], input[type=checkbox]').forEach(el => el.checked = false);
            offcanvas.querySelectorAll('.filter-chip').forEach((c, i) => c.classList.toggle('selected', i === 0));
        });
        overlay?.addEventListener('click', closeSearchFilter);

        // Filter chips inside offcanvas
        offcanvas?.querySelectorAll('.filter-chip').forEach(chip => {
            chip.addEventListener('click', function () {
                this.closest('div').querySelectorAll('.filter-chip').forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
            });
        });
    })();
    </script>

    @yield('scripts')
</body>
</html>
