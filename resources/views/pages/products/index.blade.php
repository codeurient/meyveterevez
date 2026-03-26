@extends('layouts.app')

@section('title', __t('heading.all_products'))
@section('description', __t('heading.all_products_desc'))

@section('content')

    {{-- ==================== PAGE HEADER ==================== --}}
    <section class="bg-white border-b border-gray-100 py-4">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h1 class="font-montserrat font-bold text-xl md:text-2xl text-gray-800">{{ __t('heading.all_products') }}</h1>
                    <p class="text-gray-500 text-sm mt-0.5">{{ __t('heading.all_products_desc') }}</p>
                </div>
                <nav class="text-sm text-gray-500 flex items-center gap-2">
                    <a href="{{ route('home') }}" class="hover:text-green-600 transition">{{ __t('breadcrumb.home') }}</a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span class="text-gray-800 font-medium">{{ __t('breadcrumb.products') }}</span>
                </nav>
            </div>
        </div>
    </section>

    <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8 py-6">

        {{-- Toolbar --}}
        <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
            <div class="flex items-center gap-3">
                {{-- Filter Button (all screens → opens global offcanvas) --}}
                <button onclick="openSearchFilter()"
                    class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:border-green-500 transition">
                    <i class="fas fa-sliders-h text-green-500"></i> {{ __t('label.filters') }}
                </button>
                <p class="text-sm text-gray-500"><span id="productCount">0</span> {{ __t('label.products_found') }}</p>
            </div>
            <div class="flex items-center gap-3">
                {{-- Sort --}}
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
                        <button class="sort-option w-full text-left px-4 py-2 text-sm hover:bg-green-50 hover:text-green-600 transition" data-sort="newest">{{ __t('sort.newest') }}</button>
                    </div>
                </div>
                {{-- View Toggle --}}
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

        {{-- Active Filter Tags --}}
        <div id="activeFiltersBar" class="hidden flex flex-wrap gap-2 mb-4"></div>

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

        {{-- Pagination --}}
        @if($products->hasPages())
            <div class="mt-10 flex justify-center">{{ $products->links() }}</div>
        @endif
    </div>

@endsection

@section('scripts')
<script>
    // ==================== SORT DROPDOWN ====================
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

    // ==================== VIEW TOGGLE ====================
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
