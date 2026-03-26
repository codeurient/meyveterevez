@extends('layouts.app')

@section('title', $product->meta_title ?? $product->name)
@section('description', $product->meta_description ?? Str::limit(strip_tags($product->description ?? ''), 160))

@section('content')

    {{-- ==================== BREADCRUMB ==================== --}}
    <section class="bg-white border-b border-gray-100 py-3">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-gray-500 flex items-center gap-2 flex-wrap">
                <a href="{{ route('home') }}" class="hover:text-green-600 transition">{{ __t('breadcrumb.home') }}</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="{{ route('products.index') }}" class="hover:text-green-600 transition">{{ __t('breadcrumb.products') }}</a>
                @if($product->category)
                    <i class="fas fa-chevron-right text-xs"></i>
                    <a href="{{ route('categories.show', $product->category->slug) }}" class="hover:text-green-600 transition">{{ $product->category->name }}</a>
                @endif
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-gray-800 font-medium truncate max-w-[200px]">{{ $product->name }}</span>
            </nav>
        </div>
    </section>

    <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8 py-6">

        {{-- ==================== PRODUCT MAIN SECTION ==================== --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">

            {{-- Left: Image Gallery --}}
            <div>
                @php
                    $primaryImage = $product->primaryImage ?? $product->images->first();
                    $mainImageUrl = $primaryImage ? $primaryImage->url : 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=800&q=80';
                    $allImages = $product->images->count() > 0 ? $product->images : collect([(object)['url' => $mainImageUrl, 'thumbnail_url' => $mainImageUrl]]);
                @endphp
                <div class="img-zoom-container bg-gray-50 rounded-2xl overflow-hidden aspect-square mb-3 border border-gray-100 shadow-sm">
                    <img id="mainProductImage"
                        src="{{ $mainImageUrl }}"
                        alt="{{ $product->name }}"
                        class="w-full h-full object-cover">
                </div>
                @if($allImages->count() > 1)
                    <div class="flex gap-2 overflow-x-auto pb-1" id="thumbContainer">
                        @foreach($allImages as $i => $img)
                            <button class="thumb-item w-20 h-20 rounded-xl overflow-hidden border-2 {{ $i === 0 ? 'border-green-500' : 'border-gray-200' }} shrink-0 transition"
                                data-full="{{ $img->url }}">
                                <img src="{{ $img->thumbnail_url ?? $img->url }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Right: Product Details --}}
            <div>
                {{-- Badges --}}
                @if($product->is_organic || $product->is_fresh_today || $product->discount_percent > 0)
                    <div class="flex flex-wrap gap-2 mb-3">
                        @if($product->is_organic)
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                                <i class="fas fa-leaf mr-1"></i> {{ __t('label.organic') }}
                            </span>
                        @endif
                        @if($product->is_fresh_today)
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full">
                                <i class="fas fa-bolt mr-1"></i> {{ __t('label.fresh_today') }}
                            </span>
                        @endif
                        @if($product->discount_percent > 0)
                            <span class="px-3 py-1 bg-red-100 text-red-600 text-xs font-bold rounded-full">
                                -{{ $product->discount_percent }}% {{ __t('label.off') }}
                            </span>
                        @endif
                    </div>
                @endif

                <h1 class="font-montserrat font-bold text-2xl md:text-3xl text-gray-800 mb-2">
                    {{ $product->name }}
                </h1>

                {{-- Rating --}}
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex items-center gap-0.5 text-yellow-400">
                        @php $rating = round($product->rating_avg * 2) / 2; @endphp
                        @for($s = 1; $s <= 5; $s++)
                            @if($s <= $rating)
                                <i class="fas fa-star text-sm"></i>
                            @elseif($s - 0.5 == $rating)
                                <i class="fas fa-star-half-alt text-sm"></i>
                            @else
                                <i class="far fa-star text-sm"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="font-bold text-gray-700">{{ number_format($product->rating_avg, 1) }}</span>
                    <span class="text-gray-400 text-sm">({{ $product->reviews_count ?? $product->reviews->count() }} {{ __t('label.reviews') }})</span>
                    <span class="text-gray-300">|</span>
                    @if($product->stock_quantity > 0)
                        <span class="text-green-600 text-sm font-semibold">{{ __t('label.in_stock') }}</span>
                    @else
                        <span class="text-red-400 text-sm font-semibold">{{ __t('label.out_of_stock') }}</span>
                    @endif
                </div>

                {{-- Price --}}
                <div class="flex items-baseline gap-3 mb-5">
                    <span class="text-3xl font-bold text-green-600">₼{{ number_format($product->price, 2) }}</span>
                    @if($product->original_price && $product->original_price > $product->price)
                        <span class="text-gray-400 line-through text-lg">₼{{ number_format($product->original_price, 2) }}</span>
                    @endif
                    @if($product->unit)
                        <span class="text-gray-400 text-sm">/ {{ $product->unit }}</span>
                    @endif
                </div>

                @if($product->description)
                    <p class="text-gray-600 text-sm mb-5 leading-relaxed">
                        {{ Str::limit($product->description, 300) }}
                    </p>
                @endif

                {{-- Quantity + Add to Cart --}}
                <div class="flex items-center gap-4 mb-6">
                    <div class="flex items-center gap-3 bg-gray-50 rounded-xl p-2 border border-gray-200">
                        <button class="quantity-btn" id="decreaseQty">
                            <i class="fas fa-minus text-sm"></i>
                        </button>
                        <span id="qty" class="font-bold text-lg min-w-[2rem] text-center">1</span>
                        <button class="quantity-btn" id="increaseQty">
                            <i class="fas fa-plus text-sm"></i>
                        </button>
                    </div>
                    <button class="btn-primary flex-1 flex items-center justify-center gap-2"
                        onclick="addToCart({{ $product->id }}, this)"
                        @if($product->stock_quantity <= 0) disabled @endif>
                        <i class="fas fa-shopping-cart"></i> {{ __t('button.add_to_cart') }}
                    </button>
                    <button class="w-12 h-12 border-2 border-gray-200 rounded-xl flex items-center justify-center text-gray-400 hover:text-red-500 hover:border-red-300 transition" id="favToggle"
                        data-product-id="{{ $product->id }}">
                        <i class="far fa-heart text-lg"></i>
                    </button>
                </div>

                {{-- Sold by / Store info --}}
                @if($product->store)
                    <div class="bg-gray-50 rounded-xl p-4 flex items-center gap-4 border border-gray-100">
                        <div class="w-12 h-12 rounded-xl bg-white border border-gray-100 flex items-center justify-center overflow-hidden shrink-0">
                            @if($product->store->logo)
                                <img src="{{ $product->store->logo }}" alt="{{ $product->store->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-2xl">🏪</span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500">{{ __t('label.sold_by') }}</p>
                            <a href="{{ route('stores.show', $product->store->slug) }}" class="font-bold text-gray-800 hover:text-green-600 transition text-sm truncate block">
                                {{ $product->store->name }}
                            </a>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-yellow-400 text-xs"><i class="fas fa-star"></i> {{ number_format($product->store->rating_avg, 1) }}</span>
                                @if($product->store->is_verified)
                                    <span class="text-green-500 text-xs font-semibold"><i class="fas fa-check-circle"></i> {{ __t('label.verified') }}</span>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('stores.show', $product->store->slug) }}" class="text-green-600 text-xs font-semibold hover:underline shrink-0">
                            {{ __t('button.view_store') }} <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- ==================== OTHER SELLERS ==================== --}}
        @if(isset($otherSellers) && $otherSellers->count() > 0)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-8">
            <h2 class="font-montserrat font-bold text-lg text-gray-800 mb-4">
                <i class="fas fa-store text-green-500 mr-2"></i>{{ __t('heading.compare_sellers') }}
            </h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 text-gray-500 text-left">
                            <th class="pb-3 font-semibold">{{ __t('label.seller') }}</th>
                            <th class="pb-3 font-semibold text-center">{{ __t('label.price') }}</th>
                            <th class="pb-3 font-semibold text-center">{{ __t('label.rating') }}</th>
                            <th class="pb-3 font-semibold text-center hidden sm:table-cell">{{ __t('label.stock') }}</th>
                            <th class="pb-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        {{-- Current seller (highlighted) --}}
                        @if($product->store)
                        <tr class="bg-green-50">
                            <td class="py-3 pr-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-white border border-gray-100 flex items-center justify-center overflow-hidden shrink-0">
                                        @if($product->store->logo)
                                            <img src="{{ $product->store->logo }}" alt="{{ $product->store->name }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-base">🏪</span>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $product->store->name }}</p>
                                        <span class="text-xs text-green-600 font-semibold">{{ __t('label.viewing_now') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 text-center font-bold text-green-600">₼{{ number_format($product->price, 2) }}</td>
                            <td class="py-3 text-center">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold badge-rating">
                                    <i class="fas fa-star text-xs"></i> {{ number_format($product->store->rating_avg, 1) }}
                                </span>
                            </td>
                            <td class="py-3 text-center hidden sm:table-cell">
                                @if($product->stock_quantity > 0)
                                    <span class="text-green-600 text-xs font-semibold">{{ __t('label.in_stock') }}</span>
                                @else
                                    <span class="text-red-400 text-xs">{{ __t('label.out_of_stock') }}</span>
                                @endif
                            </td>
                            <td class="py-3 text-right">
                                <span class="px-3 py-1.5 bg-green-100 text-green-700 text-xs font-semibold rounded-lg">{{ __t('label.selected') }}</span>
                            </td>
                        </tr>
                        @endif
                        {{-- Other sellers --}}
                        @foreach($otherSellers as $other)
                        <tr class="seller-row hover:bg-gray-50 transition">
                            <td class="py-3 pr-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center overflow-hidden shrink-0">
                                        @if($other->store && $other->store->logo)
                                            <img src="{{ $other->store->logo }}" alt="{{ $other->store->name }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-base">🏪</span>
                                        @endif
                                    </div>
                                    <p class="font-semibold text-gray-800">{{ $other->store->name ?? '—' }}</p>
                                </div>
                            </td>
                            <td class="py-3 text-center font-bold text-gray-800">₼{{ number_format($other->price, 2) }}</td>
                            <td class="py-3 text-center">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold badge-rating">
                                    <i class="fas fa-star text-xs"></i> {{ number_format($other->store->rating_avg ?? 0, 1) }}
                                </span>
                            </td>
                            <td class="py-3 text-center hidden sm:table-cell">
                                @if($other->stock_quantity > 0)
                                    <span class="text-green-600 text-xs font-semibold">{{ __t('label.in_stock') }}</span>
                                @else
                                    <span class="text-red-400 text-xs">{{ __t('label.out_of_stock') }}</span>
                                @endif
                            </td>
                            <td class="py-3 text-right">
                                @if($other->stock_quantity > 0)
                                    <a href="{{ route('products.show', $other->slug) }}"
                                        class="px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-semibold rounded-lg transition inline-block">
                                        {{ __t('button.view') }}
                                    </a>
                                @else
                                    <span class="px-3 py-1.5 bg-gray-100 text-gray-400 text-xs font-semibold rounded-lg">{{ __t('label.unavailable') }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- ==================== PRODUCT TABS ==================== --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm mb-8">
            <div class="flex border-b border-gray-100 overflow-x-auto">
                <button class="tab-btn px-6 py-4 text-sm font-semibold text-gray-500 whitespace-nowrap tab-active" data-tab="description">{{ __t('tab.description') }}</button>
                <button class="tab-btn px-6 py-4 text-sm font-semibold text-gray-500 whitespace-nowrap hover:text-gray-700 transition" data-tab="reviews">
                    {{ __t('tab.reviews') }} ({{ $product->reviews_count ?? $product->reviews->count() }})
                </button>
            </div>
            <div class="p-6">
                <div id="tab-description">
                    @if($product->description)
                        <p class="text-gray-600 text-sm leading-relaxed mb-4">{{ $product->description }}</p>
                    @endif
                    <ul class="space-y-2 text-sm text-gray-600">
                        @if($product->is_organic)
                            <li class="flex items-center gap-2"><i class="fas fa-check text-green-500 text-xs"></i> {{ __t('product_detail.organic_certified') }}</li>
                        @endif
                        @if($product->is_fresh_today)
                            <li class="flex items-center gap-2"><i class="fas fa-check text-green-500 text-xs"></i> {{ __t('product_detail.harvested_fresh') }}</li>
                        @endif
                        <li class="flex items-center gap-2"><i class="fas fa-check text-green-500 text-xs"></i> {{ __t('product_detail.no_preservatives') }}</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-green-500 text-xs"></i> {{ __t('product_detail.locally_sourced') }}</li>
                    </ul>
                </div>

                <div id="tab-reviews" class="hidden">
                    @php $approvedReviews = $product->reviews->where('is_approved', true); @endphp
                    @if($approvedReviews->count() > 0)
                        <div class="space-y-4">
                            @foreach($approvedReviews->take(5) as $review)
                                <div class="border-b border-gray-50 pb-4 last:border-0">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold text-sm">
                                            {{ strtoupper(substr($review->user->first_name ?? 'A', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">{{ $review->user->first_name ?? __t('label.anonymous') }}</p>
                                            <div class="flex items-center gap-1 text-yellow-400">
                                                @for($s = 1; $s <= 5; $s++)
                                                    <i class="fas fa-star text-xs {{ $s <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <span class="text-xs text-gray-400 ml-auto">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                    @if($review->comment)
                                        <p class="text-sm text-gray-600 ml-11">{{ $review->comment }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-400">
                            <i class="fas fa-comment-alt text-3xl mb-3 block"></i>
                            <p class="text-sm">{{ __t('search.no_results') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ==================== RELATED PRODUCTS ==================== --}}
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div>
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-montserrat font-bold text-xl text-gray-800">{{ __t('heading.related_products') }}</h2>
                @if($product->category)
                    <a href="{{ route('categories.show', $product->category->slug) }}" class="text-green-600 text-sm font-semibold hover:text-green-700 flex items-center gap-1">
                        {{ __t('button.view_all') }} <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                @endif
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                @foreach($relatedProducts as $related)
                    <x-ui.product-card :product="$related" />
                @endforeach
            </div>
        </div>
        @endif

    </div>

@endsection

@section('scripts')
<script>
    // ==================== QUANTITY SELECTOR ====================
    let qty = 1;
    document.getElementById('increaseQty')?.addEventListener('click', () => {
        qty++;
        document.getElementById('qty').textContent = qty;
    });
    document.getElementById('decreaseQty')?.addEventListener('click', () => {
        if (qty > 1) { qty--; document.getElementById('qty').textContent = qty; }
    });

    // ==================== THUMBNAIL GALLERY ====================
    document.querySelectorAll('.thumb-item').forEach(thumb => {
        thumb.addEventListener('click', function () {
            document.querySelectorAll('.thumb-item').forEach(t => {
                t.classList.remove('border-green-500');
                t.classList.add('border-gray-200');
            });
            this.classList.remove('border-gray-200');
            this.classList.add('border-green-500');
            document.getElementById('mainProductImage').src = this.dataset.full;
        });
    });

    // ==================== FAVORITE TOGGLE ====================
    document.getElementById('favToggle')?.addEventListener('click', function () {
        const icon = this.querySelector('i');
        const isFav = icon.classList.contains('fas');
        icon.className = isFav ? 'far fa-heart text-lg' : 'fas fa-heart text-lg';
        this.classList.toggle('text-red-500', !isFav);
        this.classList.toggle('border-red-300', !isFav);
        this.classList.toggle('text-gray-400', isFav);
        this.classList.toggle('border-gray-200', isFav);
        if (typeof showToast === 'function') {
            showToast(isFav
                ? (window.__t?.['message.removed_from_favorites'] ?? 'message.removed_from_favorites')
                : (window.__t?.['message.added_to_favorites'] ?? 'message.added_to_favorites'),
                isFav ? 'info' : 'success');
        }
    });

    // ==================== TABS ====================
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('tab-active'));
            this.classList.add('tab-active');
            ['description', 'reviews'].forEach(id => {
                const el = document.getElementById('tab-' + id);
                if (el) el.classList.toggle('hidden', id !== this.dataset.tab);
            });
        });
    });
</script>
@endsection
