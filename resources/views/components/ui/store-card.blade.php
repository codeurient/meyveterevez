{{-- Store Card Component — Props: $store (App\Models\StoreProfile) --}}
@props(['store'])

<a href="{{ route('stores.show', $store->slug) }}" class="store-card bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden block">
    {{-- Banner / Placeholder --}}
    <div class="h-20 bg-gradient-to-br from-green-400 to-green-600 relative">
        @if($store->banner)
            <img src="{{ $store->banner }}" alt="{{ $store->name }}"
                 class="w-full h-full object-cover" loading="lazy">
        @endif
        {{-- Logo --}}
        <div class="absolute -bottom-5 left-4 w-12 h-12 bg-white rounded-xl shadow-md flex items-center justify-center overflow-hidden border-2 border-white">
            @if($store->logo)
                <img src="{{ $store->logo }}" alt="{{ $store->name }}" class="w-full h-full object-cover">
            @else
                <span class="text-2xl">🏪</span>
            @endif
        </div>
        @if($store->is_verified)
            <div class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-0.5 rounded-full font-semibold flex items-center gap-1">
                <i class="fas fa-check-circle text-xs"></i> {{ __t('label.verified') }}
            </div>
        @endif
    </div>

    <div class="pt-7 pb-3 px-4">
        <h4 class="font-bold text-sm text-gray-800 truncate">{{ $store->name }}</h4>
        <div class="flex items-center gap-3 mt-1 text-xs text-gray-500">
            <span class="flex items-center gap-1">
                <i class="fas fa-star text-yellow-400"></i>
                {{ number_format((float)$store->rating_avg, 1) }}
                <span class="text-gray-400">({{ $store->rating_count }})</span>
            </span>
            <span class="flex items-center gap-1">
                <i class="fas fa-box text-green-500"></i>
                {{ $store->product_count }} {{ __t('label.products') }}
            </span>
        </div>
    </div>
</a>
