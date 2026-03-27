@extends('admin.layouts.admin')

@section('title', __t('admin.edit_category'))
@section('breadcrumb', __t('admin.panel') . ' / ' . __t('admin.nav_categories') . ' / ' . __t('admin.edit_category'))

@section('content')
<div class="max-w-xl">
    <div class="bg-white rounded-xl border border-gray-100 p-6">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                    {{ __t('admin.col_parent') }}
                    <span class="text-gray-400 font-normal">({{ __t('label.optional') }})</span>
                </label>
                <select name="parent_id"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition">
                    <option value="">— {{ __t('admin.root_category') }} —</option>
                    @foreach($parents as $parent)
                        <option value="{{ $parent->id }}"
                                {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}
                                {{ $parent->id === $category->id ? 'disabled' : '' }}>
                            {{ $parent->icon }} {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('label.name') }}</label>
                <div class="space-y-2">
                    @foreach(['az' => 'AZ 🇦🇿', 'en' => 'EN 🇬🇧'] as $locale => $flag)
                    <div class="flex items-center gap-2">
                        <span class="w-12 text-xs font-bold text-gray-500 shrink-0">{{ $flag }}</span>
                        <input type="text" name="name_translations[{{ $locale }}]"
                               value="{{ old('name_translations.' . $locale, $category->getTranslation('name', $locale, false)) }}"
                               {{ $locale === 'az' ? 'required' : '' }}
                               class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition">
                    </div>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('admin.col_slug') }}</label>
                <input type="text" name="slug" value="{{ old('slug', $category->slug) }}"
                       class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs font-mono focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition {{ $errors->has('slug') ? 'border-red-300' : '' }}"
                       placeholder="meyveler">
                @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('admin.col_icon') }} (emoji)</label>
                    <input type="text" name="icon" value="{{ old('icon', $category->icon) }}" maxlength="10"
                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition"
                           placeholder="🍎">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        {{ __t('admin.col_color') }}
                        <span class="text-gray-400 font-normal">({{ __t('label.optional') }})</span>
                    </label>
                    <input type="text" name="color" value="{{ old('color', $category->color) }}" maxlength="20"
                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs font-mono focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition"
                           placeholder="#EF4444">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                    {{ __t('label.description') }}
                    <span class="text-gray-400 font-normal">({{ __t('label.optional') }})</span>
                </label>
                <textarea name="description" rows="2"
                          class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition">{{ old('description', $category->description) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('admin.col_sort_order') }}</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0"
                       class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition">
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                <label for="is_active" class="text-xs text-gray-600 cursor-pointer">{{ __t('admin.col_status_active') }}</label>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                    {{ __t('button.save') }}
                </button>
                <a href="{{ route('admin.categories.index') }}"
                   class="text-xs text-gray-500 hover:text-gray-700 transition">
                    {{ __t('button.cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
