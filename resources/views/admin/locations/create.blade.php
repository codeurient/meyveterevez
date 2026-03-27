@extends('admin.layouts.admin')

@section('title', __t('admin.add_location'))
@section('breadcrumb', __t('admin.panel') . ' / ' . __t('admin.nav_locations') . ' / ' . __t('admin.add_location'))

@section('content')
<div class="max-w-xl">
    <div class="bg-white rounded-xl border border-gray-100 p-6">
        <form method="POST" action="{{ route('admin.locations.store') }}" class="space-y-4">
            @csrf

            {{-- Type --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('admin.col_type') }}</label>
                <select name="type" id="locationType"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition {{ $errors->has('type') ? 'border-red-300' : '' }}">
                    <option value="country" {{ old('type') === 'country' ? 'selected' : '' }}>{{ __t('admin.type_country') }}</option>
                    <option value="city"    {{ old('type') === 'city'    ? 'selected' : '' }}>{{ __t('admin.type_city') }}</option>
                </select>
            </div>

            {{-- Parent (country) — shown only for city --}}
            <div id="parentField" class="{{ old('type', 'country') === 'country' ? 'hidden' : '' }}">
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('admin.col_parent') }}</label>
                <select name="parent_id"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition {{ $errors->has('parent_id') ? 'border-red-300' : '' }}">
                    <option value="">— {{ __t('admin.select_country') }} —</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ old('parent_id') == $country->id ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Name translations --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('label.name') }}</label>
                <div class="space-y-2">
                    @foreach(['az' => 'AZ 🇦🇿', 'en' => 'EN 🇬🇧'] as $locale => $flag)
                    <div class="flex items-center gap-2">
                        <span class="w-12 text-xs font-bold text-gray-500 shrink-0">{{ $flag }}</span>
                        <input type="text" name="name_translations[{{ $locale }}]"
                               value="{{ old('name_translations.' . $locale) }}"
                               {{ $locale === 'az' ? 'required' : '' }}
                               class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition"
                               placeholder="{{ $locale === 'az' ? 'Azərbaycan' : 'Azerbaijan' }}">
                    </div>
                    @endforeach
                </div>
                {{-- hidden name fallback for validation --}}
                <input type="hidden" name="name" value="">
            </div>

            {{-- Code --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                    {{ __t('admin.col_code') }}
                    <span class="text-gray-400 font-normal">({{ __t('label.optional') }})</span>
                </label>
                <input type="text" name="code" value="{{ old('code') }}" maxlength="10"
                       class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition"
                       placeholder="AZ">
            </div>

            {{-- Map Search + Coordinates ──────────────────────────────── --}}
            <div class="space-y-3">

                {{-- Section label --}}
                <div class="flex items-center gap-2">
                    <i class="fas fa-map-marker-alt text-green-500 text-xs"></i>
                    <label class="text-xs font-semibold text-gray-600">
                        {{ __t('label.map_search') }}
                        <span class="text-gray-400 font-normal">({{ __t('label.optional') }})</span>
                    </label>
                </div>

                {{-- Search input with icon inside (relative wrapper) --}}
                <div id="mapSearchWrapper" class="relative">
                    <div class="relative">
                        {{-- Icon: absolute inside input, 8px+ gap from text --}}
                        <i class="fas fa-search absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none z-10"></i>
                        <input
                            id="mapSearchInput"
                            type="text"
                            autocomplete="off"
                            aria-label="{{ __t('placeholder.search_location') }}"
                            aria-busy="false"
                            placeholder="{{ __t('placeholder.search_location') }}"
                            class="w-full pl-8 pr-3 py-2 border border-gray-200 rounded-lg text-xs
                                   focus:outline-none focus:ring-2 focus:ring-green-500
                                   bg-gray-50 focus:bg-white transition placeholder-gray-400"
                        >
                    </div>

                    {{-- Suggestions dropdown --}}
                    <div
                        id="mapSuggestions"
                        role="listbox"
                        class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-gray-200
                               rounded-lg shadow-lg z-50 max-h-52 overflow-y-auto"
                    ></div>
                </div>

                {{-- Interactive map (hidden until location selected) --}}
                <div id="locationMapContainer"
                     class="hidden rounded-lg overflow-hidden border border-gray-200"
                     style="height: 220px;"></div>

                {{-- Click hint (hidden until map visible) --}}
                <p id="mapHint"
                   class="hidden flex items-center gap-1.5 text-xs text-gray-400">
                    <i class="fas fa-info-circle text-blue-400"></i>
                    {{ __t('label.map_click_hint') }}
                </p>

                {{-- Lat / Lng inputs in a 2-col grid --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                            {{ __t('admin.col_latitude') }}
                        </label>
                        <input type="number" id="lat_input" name="latitude"
                               value="{{ old('latitude') }}" step="any"
                               class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs
                                      focus:outline-none focus:ring-2 focus:ring-green-500
                                      bg-gray-50 focus:bg-white transition"
                               placeholder="40.4093">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                            {{ __t('admin.col_longitude') }}
                        </label>
                        <input type="number" id="lng_input" name="longitude"
                               value="{{ old('longitude') }}" step="any"
                               class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs
                                      focus:outline-none focus:ring-2 focus:ring-green-500
                                      bg-gray-50 focus:bg-white transition"
                               placeholder="49.8671">
                    </div>
                </div>
            </div>

            {{-- Active --}}
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', '1') ? 'checked' : '' }}
                       class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                <label for="is_active" class="text-xs text-gray-600 cursor-pointer">{{ __t('admin.col_status_active') }}</label>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                    {{ __t('button.save') }}
                </button>
                <a href="{{ route('admin.locations.index') }}"
                   class="text-xs text-gray-500 hover:text-gray-700 transition">
                    {{ __t('button.cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
@endsection

@section('scripts')
<script>
document.getElementById('locationType').addEventListener('change', function () {
    document.getElementById('parentField').classList.toggle('hidden', this.value !== 'city');
});
</script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV/XN/WLs=" crossorigin=""></script>
@vite('resources/js/admin/location-map.js')
@endsection
