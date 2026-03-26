{{--
    Product Card Component
    Props: $product (App\Models\Product, with primaryImage + store loaded)
           $view (optional: 'grid' | 'list', default 'grid')
--}}
@props(['product', 'view' => 'grid'])

@php
    $imageUrl = $product->primaryImage?->image_path
        ?? 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=400&q=60';
    $hasDiscount = $product->discount_percent > 0;
@endphp

@if($view === 'list')
{{-- ==================== LIST VIEW ==================== --}}
<div class="product-card bg-white rounded-2xl shadow-sm border border-gray-100 flex gap-4 p-3 hover:shadow-md">
    <a href="{{ route('products.show', $product->slug) }}" class="w-28 h-24 rounded-xl overflow-hidden shrink-0">
        <img src="{{ $imageUrl }}" alt="{{ $product->name }}"
             class="product-image w-full h-full object-cover" loading="lazy">
    </a>
    <div class="flex-1 min-w-0">
        <a href="{{ route('products.show', $product->slug) }}" class="block font-semibold text-sm text-gray-800 truncate hover:text-green-600">{{ $product->name }}</a>
        @if($product->store)
            <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $product->store->name }}</p>
        @endif
        <div class="flex items-center gap-1 mt-1">
            <i class="fas fa-star text-yellow-400 text-xs"></i>
            <span class="text-xs text-gray-600">{{ number_format((float)$product->rating_avg, 1) }}</span>
            <span class="text-xs text-gray-400">({{ $product->rating_count }})</span>
        </div>
        <div class="flex items-center justify-between mt-2">
            <div class="flex items-center gap-2">
                <span class="font-bold text-green-600">{{ number_format((float)$product->price, 2) }} ₼</span>
                @if($hasDiscount && $product->original_price)
                    <span class="text-xs text-gray-400 line-through">{{ number_format((float)$product->original_price, 2) }} ₼</span>
                @endif
            </div>
            <button onclick="addToCart({{ $product->id }}, this)"
                class="px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs rounded-xl transition font-semibold">
                <i class="fas fa-plus mr-1"></i>{{ __t('button.add') }}
            </button>
        </div>
    </div>
</div>

@else
{{-- ==================== GRID VIEW (default) ==================== --}}
<div class="product-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    {{-- Image --}}
    <div class="relative overflow-hidden" style="padding-top: 75%;">
        <a href="{{ route('products.show', $product->slug) }}" class="absolute inset-0">
            <img src="{{ $imageUrl }}" alt="{{ $product->name }}"
                 class="product-image absolute inset-0 w-full h-full object-cover" loading="lazy">
        </a>

        {{-- Badges --}}
        <div class="absolute top-2 left-2 flex flex-col gap-1">
            @if($hasDiscount)
                <span class="badge-discount text-xs font-bold px-2 py-0.5 rounded-lg">-{{ $product->discount_percent }}%</span>
            @endif
            @if($product->is_organic)
                <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-0.5 rounded-lg">{{ __t('label.organic') }}</span>
            @endif
            @if($product->is_fresh_today)
                <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-2 py-0.5 rounded-lg">{{ __t('label.fresh_today') }}</span>
            @endif
        </div>

        {{-- Wishlist --}}
        <button onclick="toggleWishlist({{ $product->id }}, this)"
            class="absolute top-2 right-2 w-8 h-8 bg-white/90 hover:bg-white rounded-full flex items-center justify-center shadow-sm transition text-gray-400 hover:text-red-500">
            <i class="far fa-heart text-sm"></i>
        </button>
    </div>

    {{-- Info --}}
    <div class="p-3">
        @if($product->store)
            <p class="text-xs text-gray-400 truncate mb-0.5">{{ $product->store->name }}</p>
        @endif
        <a href="{{ route('products.show', $product->slug) }}"
           class="block font-semibold text-sm text-gray-800 leading-snug hover:text-green-600 line-clamp-2">
            {{ $product->name }}
        </a>

        {{-- Rating --}}
        @if($product->rating_count > 0)
            <div class="flex items-center gap-1 mt-1">
                <i class="fas fa-star text-yellow-400 text-xs"></i>
                <span class="text-xs font-semibold text-gray-700">{{ number_format((float)$product->rating_avg, 1) }}</span>
                <span class="text-xs text-gray-400">({{ $product->rating_count }})</span>
            </div>
        @endif

        {{-- Price + Add --}}
        <div class="flex items-center justify-between mt-2 gap-2">
            <div>
                <span class="font-bold text-green-600 text-sm">{{ number_format((float)$product->price, 2) }} ₼</span>
                @if($hasDiscount && $product->original_price)
                    <span class="text-xs text-gray-400 line-through block leading-none">{{ number_format((float)$product->original_price, 2) }} ₼</span>
                @endif
                <span class="text-xs text-gray-400">/ {{ $product->unit }}</span>
            </div>
            <button onclick="addToCart({{ $product->id }}, this)"
                class="w-8 h-8 bg-green-500 hover:bg-green-600 text-white rounded-xl flex items-center justify-center transition shadow-sm shrink-0">
                <i class="fas fa-plus text-xs"></i>
            </button>
        </div>
    </div>
</div>
@endif
