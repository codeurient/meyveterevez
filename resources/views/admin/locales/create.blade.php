@extends('admin.layouts.admin')

@section('title', __t('admin.add_locale'))
@section('breadcrumb', __t('admin.panel') . ' / ' . __t('admin.nav_locales') . ' / ' . __t('admin.add_locale'))

@section('content')
<div class="max-w-xl">
    <div class="bg-white rounded-xl border border-gray-100 p-6">
        <form method="POST" action="{{ route('admin.locales.store') }}" class="space-y-4">
            @csrf

            <div class="grid grid-cols-2 gap-3">
                {{-- Code --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('admin.col_code') }}</label>
                    <input type="text" name="code" value="{{ old('code') }}" maxlength="5" required
                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs font-mono focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition {{ $errors->has('code') ? 'border-red-300' : '' }}"
                           placeholder="az">
                    @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Flag --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('admin.col_flag') }}</label>
                    <input type="text" name="flag" value="{{ old('flag') }}" maxlength="10"
                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition"
                           placeholder="🇦🇿">
                </div>
            </div>

            {{-- Name --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('label.name') }}</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition {{ $errors->has('name') ? 'border-red-300' : '' }}"
                       placeholder="Azərbaycan">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Native Name --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                    {{ __t('admin.col_native_name') }}
                    <span class="text-gray-400 font-normal">({{ __t('label.optional') }})</span>
                </label>
                <input type="text" name="native_name" value="{{ old('native_name') }}"
                       class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition"
                       placeholder="Azərbaycan dili">
            </div>

            <div class="grid grid-cols-2 gap-3">
                {{-- Direction --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('admin.col_dir') }}</label>
                    <select name="dir"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition">
                        <option value="ltr" {{ old('dir', 'ltr') === 'ltr' ? 'selected' : '' }}>LTR</option>
                        <option value="rtl" {{ old('dir') === 'rtl' ? 'selected' : '' }}>RTL</option>
                    </select>
                </div>

                {{-- Sort Order --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('admin.col_sort_order') }}</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition"
                           placeholder="0">
                </div>
            </div>

            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           {{ old('is_active', '1') ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                    <label for="is_active" class="text-xs text-gray-600 cursor-pointer">{{ __t('admin.col_status_active') }}</label>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_default" id="is_default" value="1"
                           {{ old('is_default') ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <label for="is_default" class="text-xs text-gray-600 cursor-pointer">{{ __t('admin.col_default') }}</label>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                    {{ __t('button.save') }}
                </button>
                <a href="{{ route('admin.locales.index') }}"
                   class="text-xs text-gray-500 hover:text-gray-700 transition">
                    {{ __t('button.cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
