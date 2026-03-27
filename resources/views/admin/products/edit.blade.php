@extends('admin.layouts.admin')

@section('title', __t('admin.edit_product'))
@section('breadcrumb', __t('admin.panel') . ' / ' . __t('admin.nav_products') . ' / ' . __t('admin.edit_product'))

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-100 p-6">
        <form method="POST" action="{{ route('admin.products.update', $product) }}" class="space-y-4" enctype="multipart/form-data">
            @csrf @method('PUT')

            {{-- Category + Store --}}
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('admin.col_category') }}</label>
                    <select name="category_id" required
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition">
                        <option value="">— {{ __t('admin.select_category') }} —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->icon }} {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('admin.col_store') }}</label>
                    <select name="store_profile_id" required
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition">
                        <option value="">— {{ __t('admin.select_store') }} —</option>
                        @foreach($stores as $store)
                            <option value="{{ $store->id }}" {{ old('store_profile_id', $product->store_profile_id) == $store->id ? 'selected' : '' }}>
                                {{ $store->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Name (bilingual) --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('label.name') }}</label>
                <div class="space-y-2">
                    @foreach(['az' => 'AZ 🇦🇿', 'en' => 'EN 🇬🇧'] as $locale => $flag)
                    <div class="flex items-center gap-2">
                        <span class="w-12 text-xs font-bold text-gray-500 shrink-0">{{ $flag }}</span>
                        <input type="text" name="name_translations[{{ $locale }}]"
                               value="{{ old('name_translations.' . $locale, $product->name_translations[$locale] ?? ($locale === 'az' ? $product->name : '')) }}"
                               {{ $locale === 'az' ? 'required' : '' }}
                               class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition {{ $errors->has('name_translations.' . $locale) ? 'border-red-300' : '' }}">
                    </div>
                    @endforeach
                </div>
                @error('name_translations.az') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Slug --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('admin.col_slug') }}</label>
                <input type="text" name="slug" value="{{ old('slug', $product->slug) }}"
                       class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs font-mono focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition {{ $errors->has('slug') ? 'border-red-300' : '' }}">
                @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Description (bilingual) --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                    {{ __t('label.description') }}
                    <span class="text-gray-400 font-normal">({{ __t('label.optional') }})</span>
                </label>
                <div class="space-y-2">
                    @foreach(['az' => 'AZ 🇦🇿', 'en' => 'EN 🇬🇧'] as $locale => $flag)
                    <div class="flex items-start gap-2">
                        <span class="w-12 text-xs font-bold text-gray-500 shrink-0 pt-2">{{ $flag }}</span>
                        <textarea name="description_translations[{{ $locale }}]" rows="2"
                                  class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition">{{ old('description_translations.' . $locale, $product->description_translations[$locale] ?? ($locale === 'az' ? $product->description : '')) }}</textarea>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Price --}}
            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('label.price') }} (₼)</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required
                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition {{ $errors->has('price') ? 'border-red-300' : '' }}">
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        {{ __t('label.original_price') }} (₼)
                        <span class="text-gray-400 font-normal">({{ __t('label.optional') }})</span>
                    </label>
                    <input type="number" name="original_price" value="{{ old('original_price', $product->original_price) }}" step="0.01" min="0"
                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('label.discount') }} (%)</label>
                    <input type="number" name="discount_percent" value="{{ old('discount_percent', $product->discount_percent) }}" min="0" max="100"
                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition">
                </div>
            </div>

            {{-- Unit + Stock --}}
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('admin.col_unit') }}</label>
                    <select name="unit"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition">
                        <option value="kg"    {{ old('unit', $product->unit) === 'kg'    ? 'selected' : '' }}>kg</option>
                        <option value="piece" {{ old('unit', $product->unit) === 'piece' ? 'selected' : '' }}>{{ __t('label.piece') }}</option>
                        <option value="bunch" {{ old('unit', $product->unit) === 'bunch' ? 'selected' : '' }}>{{ __t('label.bunch') }}</option>
                        <option value="g"     {{ old('unit', $product->unit) === 'g'     ? 'selected' : '' }}>g</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('admin.col_stock') }}</label>
                    <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0"
                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition">
                </div>
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('admin.col_status') }}</label>
                <select name="status"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition">
                    <option value="active"   {{ old('status', $product->status) === 'active'   ? 'selected' : '' }}>{{ __t('admin.status_active') }}</option>
                    <option value="draft"    {{ old('status', $product->status) === 'draft'    ? 'selected' : '' }}>{{ __t('admin.status_draft') }}</option>
                    <option value="inactive" {{ old('status', $product->status) === 'inactive' ? 'selected' : '' }}>{{ __t('admin.status_inactive') }}</option>
                </select>
            </div>

            {{-- Flags --}}
            <div class="flex flex-wrap items-center gap-4">
                @foreach(['is_organic' => 'label.organic', 'is_fresh_today' => 'label.fresh_today', 'is_featured' => 'label.featured', 'is_top_seller' => 'label.top_seller', 'in_stock' => 'label.in_stock'] as $field => $key)
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="{{ $field }}" id="{{ $field }}" value="1"
                           {{ old($field, $product->$field) ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                    <label for="{{ $field }}" class="text-xs text-gray-600 cursor-pointer">{{ __t($key) }}</label>
                </div>
                @endforeach
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                    {{ __t('button.save_changes') }}
                </button>
                <a href="{{ route('admin.products.index') }}"
                   class="text-xs text-gray-500 hover:text-gray-700 transition">
                    {{ __t('button.cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
