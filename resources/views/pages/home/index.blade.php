@extends('layouts.app')

@section('title', __t('nav.home'))
@section('description', __t('carousel.slide1_desc'))

@section('content')

    {{-- ==================== HERO CAROUSEL ==================== --}}
    <section class="banner-container" id="promoCarousel">
        <div class="slides-wrapper" id="slidesWrapper"
             style="width: {{ $sliders->count() * 100 }}%;">
            @foreach($sliders as $slider)
            <div class="slide" style="width: {{ 100 / $sliders->count() }}%; background-image: url('{{ $slider->image }}');">
                <div class="slide-overlay">
                    <div class="max-w-xl">
                        @if($slider->subtitle)
                            <span class="promo-tag mb-4 inline-block">{{ $slider->subtitle }}</span>
                        @endif
                        <h2 class="text-2xl md:text-4xl lg:text-5xl font-bold text-white mb-4 leading-tight">
                            {{ $slider->title }}
                        </h2>
                        @if($slider->link && $slider->button_text)
                            <a href="{{ $slider->link }}" class="btn-primary">
                                {{ $slider->button_text }} <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Carousel dots --}}
        <div class="dots-container">
            @foreach($sliders as $i => $slider)
                <div class="dot {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}"></div>
            @endforeach
        </div>

        {{-- Arrow Navigation --}}
        <button class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/20 hover:bg-white/40 backdrop-blur-sm rounded-full items-center justify-center text-white transition-all hidden md:flex" id="prevSlide">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/20 hover:bg-white/40 backdrop-blur-sm rounded-full items-center justify-center text-white transition-all hidden md:flex" id="nextSlide">
            <i class="fas fa-chevron-right"></i>
        </button>
    </section>

    {{-- ==================== CATEGORIES ==================== --}}
    <section class="py-10 bg-white">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-montserrat font-bold text-xl md:text-2xl text-gray-800">{{ __t('heading.shop_by_category') }}</h3>
                <a href="{{ route('categories.index') }}" class="text-green-600 font-semibold text-sm hover:text-green-700 flex items-center gap-2">
                    {{ __t('button.view_all') }} <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="category-scroll flex gap-4 md:gap-5 overflow-x-auto pb-4">
                @foreach($categories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}"
                       class="shrink-0 flex flex-col items-center gap-2 w-24 md:w-28 group">
                        <div class="w-20 h-20 md:w-24 md:h-24 rounded-2xl flex items-center justify-center text-3xl md:text-4xl transition-transform group-hover:scale-105 shadow-sm"
                             style="background-color: {{ $category->color ? $category->color . '20' : '#f0fdf4' }}; border: 2px solid {{ $category->color ?? '#22C55E' }}20;">
                            {{ $category->icon ?? '🛒' }}
                        </div>
                        <span class="text-xs font-semibold text-gray-700 text-center leading-tight">{{ $category->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ==================== FEATURED PRODUCTS ==================== --}}
    <section class="py-10" id="products">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <div>
                    <h3 class="font-montserrat font-bold text-2xl md:text-3xl text-gray-800">{{ __t('heading.featured_products') }}</h3>
                    <p class="text-gray-500 mt-1 text-sm">{{ __t('heading.featured_products_desc') }}</p>
                </div>
                <a href="{{ route('products.index') }}" class="text-green-600 font-semibold text-sm hover:text-green-700 flex items-center gap-2 mt-3 md:mt-0">
                    {{ __t('button.view_all_products') }} <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                @foreach($featuredProducts as $product)
                    <x-ui.product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- ==================== TOP SELLERS ==================== --}}
    @if($topSellerProducts->isNotEmpty())
    <section class="py-10 bg-gray-50">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-montserrat font-bold text-2xl md:text-3xl text-gray-800">{{ __t('heading.top_sellers') }}</h3>
                    <p class="text-gray-500 mt-1 text-sm">{{ __t('heading.top_sellers_desc') }}</p>
                </div>
                <a href="{{ route('products.index', ['sort' => 'rating']) }}" class="text-green-600 font-semibold text-sm hover:text-green-700 flex items-center gap-2">
                    {{ __t('button.view_all') }} <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                @foreach($topSellerProducts as $product)
                    <x-ui.product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ==================== DISCOUNTED PRODUCTS ==================== --}}
    @if($discountedProducts->isNotEmpty())
    <section class="py-10">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-montserrat font-bold text-2xl md:text-3xl text-gray-800">🔥 {{ __t('heading.hot_deals') }}</h3>
                    <p class="text-gray-500 mt-1 text-sm">{{ __t('heading.hot_deals_desc') }}</p>
                </div>
                <a href="{{ route('products.index', ['sort' => 'discount']) }}" class="text-red-500 font-semibold text-sm hover:text-red-600 flex items-center gap-2">
                    {{ __t('button.view_all') }} <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-4">
                @foreach($discountedProducts as $product)
                    <x-ui.product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ==================== POPULAR STORES ==================== --}}
    @if($featuredStores->isNotEmpty())
    <section class="py-10 bg-white">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-montserrat font-bold text-2xl md:text-3xl text-gray-800">{{ __t('heading.popular_stores') }}</h3>
                    <p class="text-gray-500 mt-1 text-sm">{{ __t('heading.popular_stores_desc') }}</p>
                </div>
                <a href="{{ route('stores.index') }}" class="text-green-600 font-semibold text-sm hover:text-green-700 flex items-center gap-2">
                    {{ __t('button.view_all_stores') }} <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($featuredStores as $store)
                    <x-ui.store-card :store="$store" />
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ==================== VALUE PROPS ==================== --}}
    <section class="py-10 bg-gray-50">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl p-6 flex items-center gap-4 shadow-sm hover:shadow-md transition">
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center text-green-600 text-2xl shrink-0"><i class="fas fa-truck"></i></div>
                    <div>
                        <h4 class="font-bold text-gray-800">{{ __t('value_prop.fast_delivery') }}</h4>
                        <p class="text-sm text-gray-500">{{ __t('value_prop.fast_delivery_desc') }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 flex items-center gap-4 shadow-sm hover:shadow-md transition">
                    <div class="w-14 h-14 bg-yellow-100 rounded-xl flex items-center justify-center text-yellow-600 text-2xl shrink-0"><i class="fas fa-money-bill-wave"></i></div>
                    <div>
                        <h4 class="font-bold text-gray-800">{{ __t('value_prop.cash_on_delivery') }}</h4>
                        <p class="text-sm text-gray-500">{{ __t('value_prop.cash_on_delivery_desc') }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 flex items-center gap-4 shadow-sm hover:shadow-md transition">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 text-2xl shrink-0"><i class="fas fa-map-marked-alt"></i></div>
                    <div>
                        <h4 class="font-bold text-gray-800">{{ __t('value_prop.local_sellers') }}</h4>
                        <p class="text-sm text-gray-500">{{ __t('value_prop.local_sellers_desc') }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-6 flex items-center gap-4 shadow-sm hover:shadow-md transition">
                    <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 text-2xl shrink-0"><i class="fas fa-leaf"></i></div>
                    <div>
                        <h4 class="font-bold text-gray-800">{{ __t('value_prop.fresh_organic') }}</h4>
                        <p class="text-sm text-gray-500">{{ __t('value_prop.fresh_organic_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ==================== NEWSLETTER ==================== --}}
    <section class="py-16 bg-gray-900">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto text-center">
                <h3 class="font-montserrat font-bold text-2xl md:text-3xl text-white mb-4">{{ __t('heading.stay_updated') }}</h3>
                <p class="text-gray-400 mb-6">{{ __t('heading.stay_updated_desc') }}</p>
                <form class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                    @csrf
                    <input type="email" name="email" placeholder="{{ __t('label.email_placeholder') }}" required
                        class="flex-1 px-5 py-3 rounded-full border border-gray-600 bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:border-green-500">
                    <button type="submit" class="btn-primary whitespace-nowrap">
                        {{ __t('button.subscribe') }} <i class="fas fa-paper-plane ml-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
<script>
    // ==================== CAROUSEL ====================
    let currentSlide = 0;
    const totalSlides = {{ $sliders->count() }};
    const wrapper = document.getElementById('slidesWrapper');
    const dots = document.querySelectorAll('.dot');

    function goToSlide(index) {
        currentSlide = (index + totalSlides) % totalSlides;
        wrapper.style.transform = `translateX(-${currentSlide * (100 / totalSlides)}%)`;
        dots.forEach((d, i) => d.classList.toggle('active', i === currentSlide));
    }

    document.getElementById('nextSlide')?.addEventListener('click', () => goToSlide(currentSlide + 1));
    document.getElementById('prevSlide')?.addEventListener('click', () => goToSlide(currentSlide - 1));
    dots.forEach(d => d.addEventListener('click', () => goToSlide(parseInt(d.dataset.index))));

    if (totalSlides > 1) setInterval(() => goToSlide(currentSlide + 1), 5000);
</script>
@endsection
