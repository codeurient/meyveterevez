@extends('admin.layouts.admin')

@section('title', __t('admin.nav_categories'))
@section('breadcrumb', __t('admin.panel') . ' / ' . __t('admin.nav_categories'))

@section('content')
<div class="flex items-center justify-between mb-4">
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.categories.index') }}"
           class="px-3 py-1.5 rounded-lg text-xs font-medium transition
                  {{ !request('parent_id') ? 'bg-green-600 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
            {{ __t('admin.all_categories') }}
        </a>
        @foreach($roots as $root)
        <a href="{{ route('admin.categories.index', ['parent_id' => $root->id]) }}"
           class="px-3 py-1.5 rounded-lg text-xs font-medium transition
                  {{ request('parent_id') == $root->id ? 'bg-green-600 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
            {{ $root->icon }} {{ $root->name }}
        </a>
        @endforeach
    </div>
    <a href="{{ route('admin.categories.create') }}"
       class="flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
        <i class="fas fa-plus text-xs"></i>
        {{ __t('admin.add_category') }}
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
    <table class="w-full text-xs">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500">{{ __t('label.name') }}</th>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_slug') }}</th>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_parent') }}</th>
                <th class="text-center px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_level') }}</th>
                <th class="text-center px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_sort_order') }}</th>
                <th class="text-center px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_status') }}</th>
                <th class="text-right px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_actions') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($categories as $category)
            <tr class="hover:bg-gray-50/50 transition">
                <td class="px-4 py-2.5">
                    <div class="flex items-center gap-2">
                        @if($category->level > 1)
                            <span class="text-gray-300 text-xs">└</span>
                        @endif
                        <span class="text-base">{{ $category->icon }}</span>
                        <span class="font-medium text-gray-800">{{ $category->name }}</span>
                        @if($category->color)
                            <span class="w-3 h-3 rounded-full shrink-0" style="background-color: {{ $category->color }}"></span>
                        @endif
                    </div>
                </td>
                <td class="px-4 py-2.5 font-mono text-gray-500">{{ $category->slug }}</td>
                <td class="px-4 py-2.5 text-gray-500">{{ $category->parent?->name ?? '—' }}</td>
                <td class="px-4 py-2.5 text-center">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                        {{ $category->level === 1 ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-600' }}">
                        {{ $category->level }}
                    </span>
                </td>
                <td class="px-4 py-2.5 text-center text-gray-500">{{ $category->sort_order }}</td>
                <td class="px-4 py-2.5 text-center">
                    <span class="inline-block w-2 h-2 rounded-full {{ $category->is_active ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                </td>
                <td class="px-4 py-2.5 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.categories.edit', $category) }}"
                           class="text-gray-400 hover:text-blue-600 transition" title="{{ __t('button.edit') }}">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
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
                    <i class="fas fa-tag text-2xl mb-2 block opacity-30"></i>
                    {{ __t('admin.no_categories') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($categories->hasPages())
    <div class="px-4 py-3 border-t border-gray-100">
        {{ $categories->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
