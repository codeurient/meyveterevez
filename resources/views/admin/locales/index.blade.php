@extends('admin.layouts.admin')

@section('title', __t('admin.nav_locales'))
@section('breadcrumb', __t('admin.panel') . ' / ' . __t('admin.nav_locales'))

@section('content')
<div class="flex items-center justify-between mb-4">
    <div></div>
    <a href="{{ route('admin.locales.create') }}"
       class="flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
        <i class="fas fa-plus text-xs"></i>
        {{ __t('admin.add_locale') }}
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
    <table class="w-full text-xs">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_flag') }}</th>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_code') }}</th>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500">{{ __t('label.name') }}</th>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_dir') }}</th>
                <th class="text-center px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_default') }}</th>
                <th class="text-center px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_status') }}</th>
                <th class="text-right px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_actions') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($locales as $locale)
            <tr class="hover:bg-gray-50/50 transition">
                <td class="px-4 py-2.5 text-base">{{ $locale->flag }}</td>
                <td class="px-4 py-2.5 font-mono font-semibold text-gray-700 uppercase">{{ $locale->code }}</td>
                <td class="px-4 py-2.5 font-medium text-gray-800">{{ $locale->name }}</td>
                <td class="px-4 py-2.5">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                        {{ $locale->dir === 'rtl' ? 'bg-purple-50 text-purple-700' : 'bg-gray-100 text-gray-600' }}">
                        {{ strtoupper($locale->dir) }}
                    </span>
                </td>
                <td class="px-4 py-2.5 text-center">
                    @if($locale->is_default)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                            {{ __t('admin.col_default') }}
                        </span>
                    @else
                        <span class="text-gray-300">—</span>
                    @endif
                </td>
                <td class="px-4 py-2.5 text-center">
                    <span class="inline-block w-2 h-2 rounded-full {{ $locale->is_active ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                </td>
                <td class="px-4 py-2.5 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.locales.edit', $locale) }}"
                           class="text-gray-400 hover:text-blue-600 transition" title="{{ __t('button.edit') }}">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.locales.destroy', $locale) }}"
                              data-confirm="{{ __t('admin.confirm_delete') }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-600 transition"
                                    title="{{ __t('button.delete') }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-4 py-8 text-center text-gray-400">
                    <i class="fas fa-globe text-2xl mb-2 block opacity-30"></i>
                    {{ __t('admin.no_locales') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
