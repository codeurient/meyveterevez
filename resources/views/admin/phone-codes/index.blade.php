@extends('admin.layouts.admin')

@section('title', __t('admin.nav_phone_codes'))
@section('breadcrumb', __t('admin.panel') . ' / ' . __t('admin.nav_phone_codes'))

@section('content')
<div class="flex items-center justify-between mb-4">
    <p class="text-xs text-gray-500">{{ __t('admin.total_records', ['count' => $codes->total()]) }}</p>
    <a href="{{ route('admin.phone-codes.create') }}"
       class="flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
        <i class="fas fa-plus text-xs"></i>
        {{ __t('admin.add_phone_code') }}
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
    <table class="w-full text-xs">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_code') }}</th>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500">{{ __t('label.name') }}</th>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_native_name') }}</th>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_phone_code') }}</th>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_trunk_prefix') }}</th>
                <th class="text-center px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_status') }}</th>
                <th class="text-right px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_actions') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($codes as $code)
            <tr class="hover:bg-gray-50/50 transition">
                <td class="px-4 py-2.5 font-mono font-bold text-gray-700">{{ $code->code }}</td>
                <td class="px-4 py-2.5 font-medium text-gray-800">{{ $code->name }}</td>
                <td class="px-4 py-2.5 text-gray-500">{{ $code->native_name }}</td>
                <td class="px-4 py-2.5">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 font-mono font-semibold text-xs">
                        {{ $code->phone_code }}
                    </span>
                </td>
                <td class="px-4 py-2.5 text-gray-500 font-mono">{{ $code->trunk_prefix ?? '—' }}</td>
                <td class="px-4 py-2.5 text-center">
                    <span class="inline-block w-2 h-2 rounded-full {{ $code->is_active ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                </td>
                <td class="px-4 py-2.5 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.phone-codes.edit', $code) }}"
                           class="text-gray-400 hover:text-blue-600 transition" title="{{ __t('button.edit') }}">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.phone-codes.destroy', $code) }}"
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
                    <i class="fas fa-phone text-2xl mb-2 block opacity-30"></i>
                    {{ __t('admin.no_phone_codes') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($codes->hasPages())
    <div class="px-4 py-3 border-t border-gray-100">
        {{ $codes->links() }}
    </div>
    @endif
</div>
@endsection
