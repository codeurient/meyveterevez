@extends('layouts.app')

@section('title', request('q') ? __t('search.results_for') . ' "' . request('q') . '"' : __t('search.title'))
@section('description', __t('heading.all_products_desc'))

@section('content')

    {{-- ==================== SEARCH HEADER ==================== --}}
    <section class="bg-white border-b border-gray-100 py-5">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    @if(request('q'))
                        <h1 class="font-montserrat font-bold text-xl md:text-2xl text-gray-800">
                            {{ __t('search.results_for') }} "<span class="text-green-600">{{ request('q') }}</span>"
                        </h1>
                        <p class="text-gray-500 text-sm mt-0.5">
                            {{ $products->total() }} {{ __t('label.products_found') }}
                        </p>
                    @else
                        <h1 class="font-montserrat font-bold text-xl md:text-2xl text-gray-800">{{ __t('search.title') }}</h1>
                        <p class="text-gray-500 text-sm mt-0.5">{{ __t('search.empty_hint') }}</p>
                    @endif
                </div>
                <nav class="text-sm text-gray-500 flex items-center gap-2">
                    <a href="{{ route('home') }}" class="hover:text-green-600 transition">{{ __t('breadcrumb.home') }}</a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <a href="{{ route('products.index') }}" class="hover:text-green-600 transition">{{ __t('breadcrumb.products') }}</a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span class="text-gray-800 font-medium">{{ __t('breadcrumb.search') }}</span>
                </nav>
            </div>
            <div id="activeFiltersBar" class="flex flex-wrap gap-2 mt-3 hidden"></div>
        </div>
    </section>

    <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8 py-6">

        {{-- Toolbar --}}
        <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
            <div class="flex items-center gap-3">
                {{-- Filter Button (all screens → global offcanvas) --}}
                <button onclick="openSearchFilter()"
                    class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:border-green-500 transition">
                    <i class="fas fa-sliders-h text-green-500"></i> {{ __t('label.filters') }}
                </button>
            </div>
            <div class="flex items-center gap-3">
                <div class="sort-dropdown relative">
                    <button class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:border-green-500 transition" id="sortBtn">
                        <i class="fas fa-sort text-green-500"></i>
                        <span id="sortLabel">{{ __t('sort.relevance') }}</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <div class="sort-menu absolute right-0 top-full mt-2 bg-white rounded-xl shadow-xl border border-gray-100 py-2 min-w-[160px] z-20">
                        <button class="sort-option w-full text-left px-4 py-2 text-sm hover:bg-green-50 hover:text-green-600 transition" data-sort="relevance">{{ __t('sort.relevance') }}</button>
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

        @if(request('q'))
            @if($products->count() > 0)
                <div id="searchResults" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4">
                    @foreach($products as $product)
                        <x-ui.product-card :product="$product" />
                    @endforeach
                </div>
                @if($products->hasPages())
                    <div class="mt-10 flex justify-center">{{ $products->links() }}</div>
                @endif
            @else
                <div class="text-center py-24">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-search text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="font-bold text-lg text-gray-700 mb-2">{{ __t('search.no_results') }}</h3>
                    <p class="text-gray-500 text-sm mb-6">{{ __t('search.no_results_hint') }}</p>
                    <a href="{{ route('products.index') }}" class="btn-primary">{{ __t('button.browse_all') }}</a>
                </div>
            @endif
        @else
            <div class="text-center py-24">
                <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-search text-3xl text-green-400"></i>
                </div>
                <h3 class="font-bold text-lg text-gray-700 mb-2">{{ __t('search.what_looking_for') }}</h3>
                <p class="text-gray-500 text-sm mb-6">{{ __t('search.use_bar_hint') }}</p>
                <a href="{{ route('products.index') }}" class="btn-secondary">{{ __t('button.browse_all') }}</a>
            </div>
        @endif
    </div>

@endsection

@section('scripts')
<script>
    const query = @json(request('q') ?? '');

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
        });
    });
</script>
@endsection
