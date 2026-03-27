@extends('admin.layouts.admin')

@section('title', __t('admin.edit_translation'))
@section('breadcrumb', __t('admin.panel') . ' / ' . __t('admin.nav_translations') . ' / ' . __t('admin.edit_translation'))

@section('content')
<div class="max-w-xl">
    <div class="bg-white rounded-xl border border-gray-100 p-6">
        <form method="POST" action="{{ route('admin.translations.update', $translation) }}" class="space-y-4">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('admin.col_group') }}</label>
                    <select name="group"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition">
                        @foreach(['button','nav','label','placeholder','message','heading','error','email','auth','admin'] as $g)
                            <option value="{{ $g }}" {{ old('group', $translation->group) === $g ? 'selected' : '' }}>{{ $g }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('admin.col_locale') }}</label>
                    <select name="locale"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition">
                        @foreach($locales as $loc)
                            <option value="{{ $loc->code }}" {{ old('locale', $translation->locale) === $loc->code ? 'selected' : '' }}>
                                {{ $loc->flag }} {{ strtoupper($loc->code) }} — {{ $loc->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('admin.col_key') }}</label>
                <input type="text" name="key" value="{{ old('key', $translation->key) }}" required
                       class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs font-mono focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition {{ $errors->has('key') ? 'border-red-300' : '' }}"
                       placeholder="button.save">
                @error('key') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('admin.col_value') }}</label>
                <textarea name="value" rows="3" required
                          class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition {{ $errors->has('value') ? 'border-red-300' : '' }}">{{ old('value', $translation->value) }}</textarea>
                @error('value') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', $translation->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                <label for="is_active" class="text-xs text-gray-600 cursor-pointer">{{ __t('admin.col_status_active') }}</label>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                    {{ __t('button.save') }}
                </button>
                <a href="{{ route('admin.translations.index') }}"
                   class="text-xs text-gray-500 hover:text-gray-700 transition">
                    {{ __t('button.cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
