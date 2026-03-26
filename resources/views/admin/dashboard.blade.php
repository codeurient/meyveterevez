@extends('admin.layouts.admin')

@section('title', __t('admin.dashboard'))

@section('content')
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['icon' => 'fas fa-users',          'label' => __t('admin.stat_users'),     'value' => $totalUsers,     'color' => 'blue'],
        ['icon' => 'fas fa-map-marker-alt', 'label' => __t('admin.stat_locations'), 'value' => $totalLocations, 'color' => 'green'],
        ['icon' => 'fas fa-flag',           'label' => __t('admin.stat_countries'), 'value' => $totalCountries, 'color' => 'purple'],
        ['icon' => 'fas fa-phone',          'label' => __t('admin.stat_codes'),     'value' => $totalCodes,     'color' => 'amber'],
    ] as $stat)
    <div class="bg-white rounded-xl border border-gray-100 p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-{{ $stat['color'] }}-50 flex items-center justify-center shrink-0">
            <i class="{{ $stat['icon'] }} text-{{ $stat['color'] }}-500 text-sm"></i>
        </div>
        <div>
            <p class="text-xs text-gray-500">{{ $stat['label'] }}</p>
            <p class="text-xl font-bold text-gray-800">{{ number_format($stat['value']) }}</p>
        </div>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    {{-- Quick links --}}
    <div class="bg-white rounded-xl border border-gray-100 p-5">
        <h2 class="font-semibold text-gray-700 mb-4 text-sm">{{ __t('admin.quick_actions') }}</h2>
        <div class="space-y-2">
            <a href="{{ route('admin.locations.create') }}"
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition group">
                <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center group-hover:bg-green-100 transition">
                    <i class="fas fa-plus text-green-600 text-xs"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-700">{{ __t('admin.add_location') }}</p>
                    <p class="text-xs text-gray-400">{{ __t('admin.add_location_desc') }}</p>
                </div>
            </a>
            <a href="{{ route('admin.phone-codes.create') }}"
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition group">
                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center group-hover:bg-blue-100 transition">
                    <i class="fas fa-plus text-blue-600 text-xs"></i>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-700">{{ __t('admin.add_phone_code') }}</p>
                    <p class="text-xs text-gray-400">{{ __t('admin.add_phone_code_desc') }}</p>
                </div>
            </a>
        </div>
    </div>

    {{-- Stats breakdown --}}
    <div class="bg-white rounded-xl border border-gray-100 p-5">
        <h2 class="font-semibold text-gray-700 mb-4 text-sm">{{ __t('admin.location_breakdown') }}</h2>
        <div class="space-y-3">
            @foreach([
                ['label' => __t('admin.countries'), 'value' => $totalCountries, 'pct' => $totalLocations ? round($totalCountries / $totalLocations * 100) : 0, 'color' => 'bg-purple-500'],
                ['label' => __t('admin.cities'),    'value' => $totalCities,    'pct' => $totalLocations ? round($totalCities / $totalLocations * 100) : 0,    'color' => 'bg-green-500'],
            ] as $item)
            <div>
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs text-gray-500">{{ $item['label'] }}</span>
                    <span class="text-xs font-semibold text-gray-700">{{ $item['value'] }}</span>
                </div>
                <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="{{ $item['color'] }} h-full rounded-full transition-all" style="width: {{ $item['pct'] }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
