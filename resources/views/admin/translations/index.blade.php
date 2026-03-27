@extends('admin.layouts.admin')

@section('title', __t('admin.nav_translations'))
@section('breadcrumb', __t('admin.panel') . ' / ' . __t('admin.nav_translations'))

@section('content')
<div class="flex items-center justify-between mb-4">
    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.translations.index') }}" class="flex items-center gap-2">
        <select name="locale" onchange="this.form.submit()"
                class="px-3 py-1.5 border border-gray-200 rounded-lg text-xs bg-white focus:outline-none focus:ring-2 focus:ring-green-500">
            <option value="">{{ __t('admin.all_locales') }}</option>
            @foreach($locales as $loc)
                <option value="{{ $loc->code }}" {{ request('locale') === $loc->code ? 'selected' : '' }}>
                    {{ $loc->flag }} {{ strtoupper($loc->code) }}
                </option>
            @endforeach
        </select>
        <select name="group" onchange="this.form.submit()"
                class="px-3 py-1.5 border border-gray-200 rounded-lg text-xs bg-white focus:outline-none focus:ring-2 focus:ring-green-500">
            <option value="">{{ __t('admin.all_groups') }}</option>
            @foreach($groups as $group)
                <option value="{{ $group }}" {{ request('group') === $group ? 'selected' : '' }}>{{ $group }}</option>
            @endforeach
        </select>
        <div class="relative">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="{{ __t('placeholder.search') }}"
                   class="pl-7 pr-3 py-1.5 border border-gray-200 rounded-lg text-xs bg-white focus:outline-none focus:ring-2 focus:ring-green-500 w-48">
            <i class="fas fa-search absolute left-2 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
        </div>
    </form>
    <a href="{{ route('admin.translations.create') }}"
       class="flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
        <i class="fas fa-plus text-xs"></i>
        {{ __t('admin.add_translation') }}
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
    <table class="w-full text-xs">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_key') }}</th>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_group') }}</th>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_locale') }}</th>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_value') }}</th>
                <th class="text-center px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_status') }}</th>
                <th class="text-right px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_actions') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($translations as $translation)
            <tr class="hover:bg-gray-50/50 transition">
                <td class="px-4 py-2.5 font-mono text-gray-700">{{ $translation->key }}</td>
                <td class="px-4 py-2.5">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                        {{ $translation->group }}
                    </span>
                </td>
                <td class="px-4 py-2.5 font-semibold text-gray-500 uppercase">{{ $translation->locale }}</td>
                <td class="px-4 py-2.5 text-gray-700 max-w-xs truncate">{{ $translation->value }}</td>
                <td class="px-4 py-2.5 text-center">
                    <span class="inline-block w-2 h-2 rounded-full {{ $translation->is_active ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                </td>
                <td class="px-4 py-2.5 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.translations.edit', $translation) }}"
                           class="text-gray-400 hover:text-blue-600 transition" title="{{ __t('button.edit') }}">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.translations.destroy', $translation) }}"
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
                <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                    <i class="fas fa-language text-2xl mb-2 block opacity-30"></i>
                    {{ __t('admin.no_translations') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($translations->hasPages())
    <div class="px-4 py-3 border-t border-gray-100">
        {{ $translations->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
