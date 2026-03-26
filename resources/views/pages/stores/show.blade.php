@extends('layouts.app')

@section('title', $store->meta_title ?? $store->name)
@section('description', $store->meta_description ?? __t('heading.popular_stores_desc'))

@section('content')

    {{-- ==================== STORE HERO ==================== --}}
    <section class="relative overflow-hidden">
        {{-- Banner --}}
        <div class="h-36 md:h-48 bg-gradient-to-r from-green-600 to-green-400 relative">
            @if($store->banner)
                <img src="{{ $store->banner }}" alt="{{ $store->name }}"
                     class="w-full h-full object-cover" loading="lazy">
                <div class="absolute inset-0 bg-black/20"></div>
            @endif
        </div>

        {{-- Store Info Bar --}}
        <div class="bg-white border-b border-gray-100 shadow-sm">
            <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex flex-col sm:flex-row sm:items-end gap-4">
                    {{-- Logo --}}
                    <div class="w-20 h-20 rounded-2xl bg-white border-2 border-white shadow-md flex items-center justify-center overflow-hidden -mt-10 shrink-0">
                        @if($store->logo)
                            <img src="{{ $store->logo }}" alt="{{ $store->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-4xl">🏪</span>
                        @endif
                    </div>
                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <h1 class="font-montserrat font-bold text-xl md:text-2xl text-gray-800">{{ $store->name }}</h1>
                            @if($store->is_verified)
                                <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-semibold rounded-full flex items-center gap-1">
                                    <i class="fas fa-check-circle text-xs"></i> {{ __t('label.verified') }}
                                </span>
                            @endif
                        </div>
                        @if($store->description)
                            <p class="text-gray-500 text-sm line-clamp-2">{{ $store->description }}</p>
                        @endif
                        <div class="flex flex-wrap items-center gap-4 mt-2 text-sm text-gray-500">
                            <span class="flex items-center gap-1">
                                <i class="fas fa-star text-yellow-400 text-xs"></i>
                                <span class="font-semibold text-gray-700">{{ number_format($store->rating_avg, 1) }}</span>
                                <span class="text-gray-400">({{ $store->rating_count }})</span>
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fas fa-box text-green-500 text-xs"></i>
                                {{ $products->total() }} {{ __t('label.products_found') }}
                            </span>
                        </div>
                    </div>
                    {{-- Breadcrumb --}}
                    <nav class="text-sm text-gray-500 flex items-center gap-2 shrink-0">
                        <a href="{{ route('home') }}" class="hover:text-green-600 transition">{{ __t('breadcrumb.home') }}</a>
                        <i class="fas fa-chevron-right text-xs"></i>
                        <a href="{{ route('stores.index') }}" class="hover:text-green-600 transition">{{ __t('nav.stores') }}</a>
                        <i class="fas fa-chevron-right text-xs"></i>
                        <span class="text-gray-800 font-medium truncate max-w-[120px]">{{ $store->name }}</span>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8 py-6">

        {{-- Toolbar --}}
        <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
            <div class="flex items-center gap-3">
                <button onclick="openSearchFilter()"
                    class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:border-green-500 transition">
                    <i class="fas fa-sliders-h text-green-500"></i> {{ __t('label.filters') }}
                </button>
            </div>
            <div class="flex items-center gap-3">
                <div class="sort-dropdown relative">
                    <button class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:border-green-500 transition" id="sortBtn">
                        <i class="fas fa-sort text-green-500"></i>
                        <span id="sortLabel">{{ __t('sort.default') }}</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <div class="sort-menu absolute right-0 top-full mt-2 bg-white rounded-xl shadow-xl border border-gray-100 py-2 min-w-[160px] z-20">
                        <button class="sort-option w-full text-left px-4 py-2 text-sm hover:bg-green-50 hover:text-green-600 transition" data-sort="default">{{ __t('sort.default') }}</button>
                        <button class="sort-option w-full text-left px-4 py-2 text-sm hover:bg-green-50 hover:text-green-600 transition" data-sort="price-asc">{{ __t('sort.price_asc') }}</button>
                        <button class="sort-option w-full text-left px-4 py-2 text-sm hover:bg-green-50 hover:text-green-600 transition" data-sort="price-desc">{{ __t('sort.price_desc') }}</button>
                        <button class="sort-option w-full text-left px-4 py-2 text-sm hover:bg-green-50 hover:text-green-600 transition" data-sort="rating">{{ __t('sort.top_rated') }}</button>
                    </div>
                </div>
                <div class="flex bg-gray-100 rounded-xl p-1 gap-1">
                    <button class="view-btn active w-8 h-8 rounded-lg flex items-center justify-center text-gray-600 transition" data-view="grid">
                        <i class="fas fa-th text-sm"></i>
                    </button>
                    <button class="view-btn w-8 h-8 rounded-lg flex items-center justify-center text-gray-600 transition" data-view="list">
                        <i class="fas fa-list text-sm"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Product Grid --}}
        <div id="productsGrid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4">
            @forelse($products as $product)
                <x-ui.product-card :product="$product" />
            @empty
                <div class="col-span-full text-center py-16 text-gray-500">
                    <i class="fas fa-box-open text-4xl mb-4 block text-gray-300"></i>
                    {{ __t('search.no_results') }}
                </div>
            @endforelse
        </div>

        @if($products->hasPages())
            <div class="mt-10 flex justify-center">{{ $products->links() }}</div>
        @endif

    </div>

@endsection

@section('scripts')
<script>
    const sortBtn = document.getElementById('sortBtn');
    sortBtn?.addEventListener('click', () => sortBtn.closest('.sort-dropdown').classList.toggle('open'));
    document.querySelectorAll('.sort-option').forEach(opt => {
        opt.addEventListener('click', function () {
            document.getElementById('sortLabel').textContent = this.textContent.trim();
            sortBtn.closest('.sort-dropdown').classList.remove('open');
        });
    });
    document.addEventListener('click', e => {
        if (!e.target.closest('.sort-dropdown')) document.querySelectorAll('.sort-dropdown').forEach(d => d.classList.remove('open'));
    });

    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active', 'bg-white', 'shadow-sm', 'text-green-600'));
            this.classList.add('active', 'bg-white', 'shadow-sm', 'text-green-600');
            const grid = document.getElementById('productsGrid');
            grid.className = this.dataset.view === 'list'
                ? 'space-y-3'
                : 'grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4';
        });
    });
</script>
@endsection
