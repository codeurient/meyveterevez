@extends('admin.layouts.admin')

@section('title', __t('admin.edit_phone_code') . ': ' . $phoneCode->code)
@section('breadcrumb', __t('admin.panel') . ' / ' . __t('admin.nav_phone_codes') . ' / ' . __t('admin.edit_phone_code'))

@section('content')
<div class="max-w-lg">
    <div class="bg-white rounded-xl border border-gray-100 p-6">
        <form method="POST" action="{{ route('admin.phone-codes.update', $phoneCode) }}" class="space-y-4">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-3">
                {{-- Code (read-only after creation — it's the PK) --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('admin.col_code') }}</label>
                    <input type="text" name="code" value="{{ old('code', $phoneCode->code) }}" required maxlength="10"
                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs bg-gray-100 font-mono text-gray-500"
                           readonly>
                </div>

                {{-- Phone code --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('admin.col_phone_code') }}</label>
                    <input type="text" name="phone_code" value="{{ old('phone_code', $phoneCode->phone_code) }}" required maxlength="10"
                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition font-mono {{ $errors->has('phone_code') ? 'border-red-300' : '' }}"
                           placeholder="+994">
                </div>
            </div>

            {{-- Name translations --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('label.name') }}</label>
                <div class="space-y-2">
                    @foreach(['az' => 'AZ 🇦🇿', 'en' => 'EN 🇬🇧'] as $locale => $flag)
                    <div class="flex items-center gap-2">
                        <span class="w-12 text-xs font-bold text-gray-500 shrink-0">{{ $flag }}</span>
                        <input type="text" name="name_translations[{{ $locale }}]"
                               value="{{ old('name_translations.' . $locale, $phoneCode->name_translations[$locale] ?? ($locale === 'en' ? $phoneCode->name : '')) }}"
                               maxlength="100" {{ $locale === 'en' ? 'required' : '' }}
                               class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition"
                               placeholder="{{ $locale === 'az' ? 'Azərbaycan' : 'Azerbaijan' }}">
                    </div>
                    @endforeach
                </div>
                <input type="hidden" name="name" value="{{ $phoneCode->name }}">
            </div>

            {{-- Native name --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('admin.col_native_name') }}</label>
                <input type="text" name="native_name" value="{{ old('native_name', $phoneCode->native_name) }}" required maxlength="100"
                       class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition {{ $errors->has('native_name') ? 'border-red-300' : '' }}"
                       placeholder="Azərbaycan">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        {{ __t('admin.col_trunk_prefix') }}
                        <span class="text-gray-400 font-normal">({{ __t('label.optional') }})</span>
                    </label>
                    <input type="text" name="trunk_prefix" value="{{ old('trunk_prefix', $phoneCode->trunk_prefix) }}" maxlength="5"
                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition font-mono"
                           placeholder="0">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        {{ __t('admin.col_idd_prefix') }}
                        <span class="text-gray-400 font-normal">({{ __t('label.optional') }})</span>
                    </label>
                    <input type="text" name="idd_prefix" value="{{ old('idd_prefix', $phoneCode->idd_prefix) }}" maxlength="10"
                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition font-mono"
                           placeholder="00">
                </div>
            </div>

            {{-- Active --}}
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', $phoneCode->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                <label for="is_active" class="text-xs text-gray-600 cursor-pointer">{{ __t('admin.col_status_active') }}</label>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                    {{ __t('button.save_changes') }}
                </button>
                <a href="{{ route('admin.phone-codes.index') }}"
                   class="text-xs text-gray-500 hover:text-gray-700 transition">
                    {{ __t('button.cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
