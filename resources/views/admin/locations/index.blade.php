@extends('admin.layouts.admin')

@section('title', __t('admin.nav_locations'))
@section('breadcrumb', __t('admin.panel') . ' / ' . __t('admin.nav_locations'))

@section('content')
{{-- Toolbar --}}
<div class="flex items-center justify-between mb-4">
    <div class="flex items-center gap-2">
        @foreach(['country' => __t('admin.countries'), 'city' => __t('admin.cities')] as $t => $label)
            <a href="{{ route('admin.locations.index', ['type' => $t]) }}"
               class="px-3 py-1.5 rounded-lg text-xs font-medium transition
                      {{ $type === $t ? 'bg-green-600 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>
    <a href="{{ route('admin.locations.create') }}"
       class="flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
        <i class="fas fa-plus text-xs"></i>
        {{ __t('admin.add_location') }}
    </a>
</div>

{{-- Table --}}
<div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
    <table class="w-full text-xs">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500">{{ __t('label.name') }}</th>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_type') }}</th>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_parent') }}</th>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_code') }}</th>
                <th class="text-center px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_status') }}</th>
                <th class="text-right px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_actions') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($locations as $loc)
            <tr class="hover:bg-gray-50/50 transition">
                <td class="px-4 py-2.5 font-medium text-gray-800">{{ $loc->name }}</td>
                <td class="px-4 py-2.5">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                        {{ $loc->type === 'country' ? 'bg-purple-50 text-purple-700' : 'bg-green-50 text-green-700' }}">
                        {{ __t('admin.type_' . $loc->type) }}
                    </span>
                </td>
                <td class="px-4 py-2.5 text-gray-500">{{ $loc->parent?->name ?? '—' }}</td>
                <td class="px-4 py-2.5 text-gray-500">{{ $loc->code ?? '—' }}</td>
                <td class="px-4 py-2.5 text-center">
                    <span class="inline-block w-2 h-2 rounded-full {{ $loc->is_active ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                </td>
                <td class="px-4 py-2.5 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.locations.edit', $loc) }}"
                           class="text-gray-400 hover:text-blue-600 transition" title="{{ __t('button.edit') }}">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.locations.destroy', $loc) }}"
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
                    <i class="fas fa-map-marker-alt text-2xl mb-2 block opacity-30"></i>
                    {{ __t('admin.no_locations') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($locations->hasPages())
    <div class="px-4 py-3 border-t border-gray-100">
        {{ $locations->links() }}
    </div>
    @endif
</div>
@endsection
