@extends('admin.layouts.admin')

@section('title', __t('admin.nav_categories'))
@section('breadcrumb', __t('admin.panel') . ' / ' . __t('admin.nav_categories'))

@section('content')

{{-- Header bar --}}
<div class="flex items-center justify-between mb-5">
    <div>
        <h1 class="text-sm font-bold text-gray-800">{{ __t('admin.nav_categories') }}</h1>
        <p class="text-xs text-gray-400 mt-0.5">{{ $categories->total() }} {{ __t('admin.total_records', ['count' => '']) }}</p>
    </div>
    <a href="{{ route('admin.categories.create') }}"
       class="flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
        <i class="fas fa-plus text-xs"></i>
        {{ __t('admin.add_category') }}
    </a>
</div>

{{-- Filter tabs --}}
<div class="flex items-center gap-1.5 mb-4 flex-wrap">
    <a href="{{ route('admin.categories.index') }}"
       class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium transition
              {{ !request('parent_id') ? 'bg-gray-800 text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
        <i class="fas fa-layer-group text-xs"></i>
        {{ __t('admin.all_categories') }}
    </a>
    @foreach($roots as $root)
    <a href="{{ route('admin.categories.index', ['parent_id' => $root->id]) }}"
       class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium transition
              {{ request('parent_id') == $root->id ? 'bg-gray-800 text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
        <span>{{ $root->icon }}</span>
        {{ $root->name }}
    </a>
    @endforeach
</div>

{{-- Legend --}}
<div class="flex items-center gap-4 mb-3 text-xs text-gray-400">
    <span class="flex items-center gap-1.5">
        <span class="inline-block w-3 h-3 rounded-sm bg-blue-100 border border-blue-300"></span>
        {{ __t('admin.root_category') }}
    </span>
    <span class="flex items-center gap-1.5">
        <span class="inline-block w-3 h-3 rounded-sm bg-gray-50 border border-gray-200"></span>
        {{ __t('admin.nav_categories') }} (sub)
    </span>
</div>

{{-- Table --}}
<div class="bg-white rounded-xl border border-gray-100 overflow-hidden shadow-xs">
    <table class="w-full text-xs">
        <thead>
            <tr class="border-b border-gray-100 bg-gray-50/80">
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500 uppercase tracking-wide text-[10px]">{{ __t('label.name') }}</th>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500 uppercase tracking-wide text-[10px] hidden sm:table-cell">{{ __t('admin.col_slug') }}</th>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500 uppercase tracking-wide text-[10px] hidden md:table-cell">{{ __t('admin.col_parent') }}</th>
                <th class="text-center px-4 py-2.5 font-semibold text-gray-500 uppercase tracking-wide text-[10px]">{{ __t('admin.col_status') }}</th>
                <th class="text-center px-4 py-2.5 font-semibold text-gray-500 uppercase tracking-wide text-[10px] hidden lg:table-cell">{{ __t('admin.col_sort_order') }}</th>
                <th class="text-right px-4 py-2.5 font-semibold text-gray-500 uppercase tracking-wide text-[10px]">{{ __t('admin.col_actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)

            @if($category->level === 1)
            {{-- ── Parent / Root category row ────────────────────────────── --}}
            <tr class="border-b border-gray-100 bg-blue-50/40 hover:bg-blue-50/70 transition group">
                <td class="px-4 py-3">
                    <div class="flex items-center gap-2.5">
                        {{-- Color accent bar --}}
                        @if($category->color)
                        <span class="shrink-0 w-1 h-7 rounded-full" style="background-color: {{ $category->color }}"></span>
                        @else
                        <span class="shrink-0 w-1 h-7 rounded-full bg-blue-300"></span>
                        @endif

                        {{-- Icon badge --}}
                        <span class="flex items-center justify-center w-7 h-7 rounded-lg bg-white border border-gray-200 text-base shadow-xs shrink-0">
                            {{ $category->icon ?: '📁' }}
                        </span>

                        <div>
                            <span class="font-bold text-gray-800 text-xs block leading-tight">{{ $category->name }}</span>
                            <span class="inline-flex items-center gap-1 mt-0.5 text-[10px] font-medium text-blue-600 bg-blue-100 px-1.5 py-0.5 rounded-full leading-none">
                                <i class="fas fa-folder text-[9px]"></i>
                                {{ __t('admin.root_category') }}
                            </span>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3 hidden sm:table-cell">
                    <code class="text-[10px] text-gray-500 bg-gray-100 px-1.5 py-0.5 rounded font-mono">{{ $category->slug }}</code>
                </td>
                <td class="px-4 py-3 hidden md:table-cell">
                    <span class="text-gray-400 text-xs">—</span>
                </td>
                <td class="px-4 py-3 text-center">
                    @if($category->is_active)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-green-100 text-green-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                            {{ __t('admin.status_active') }}
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium bg-gray-100 text-gray-500">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                            {{ __t('admin.status_inactive') }}
                        </span>
                    @endif
                </td>
                <td class="px-4 py-3 text-center hidden lg:table-cell">
                    <span class="text-gray-400 font-mono text-xs">{{ $category->sort_order }}</span>
                </td>
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-1.5 opacity-0 group-hover:opacity-100 transition">
                        <a href="{{ route('admin.categories.edit', $category) }}"
                           class="inline-flex items-center justify-center w-6 h-6 rounded-md text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition"
                           title="{{ __t('button.edit') }}">
                            <i class="fas fa-pencil-alt text-xs"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                              data-confirm="{{ __t('admin.confirm_delete') }}">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center justify-center w-6 h-6 rounded-md text-gray-400 hover:text-red-600 hover:bg-red-50 transition"
                                    title="{{ __t('button.delete') }}">
                                <i class="fas fa-trash-alt text-xs"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>

            @else
            {{-- ── Subcategory row ────────────────────────────────────────── --}}
            <tr class="border-b border-gray-50 hover:bg-gray-50/60 transition group">
                <td class="px-4 py-2.5">
                    <div class="flex items-center gap-2.5" style="padding-left: {{ ($category->level - 1) * 16 }}px">
                        {{-- Tree connector --}}
                        <span class="shrink-0 text-gray-300 text-xs leading-none select-none">└</span>

                        {{-- Icon (smaller for subcategories) --}}
                        <span class="flex items-center justify-center w-6 h-6 rounded-md bg-gray-100 text-sm shrink-0">
                            {{ $category->icon ?: '📂' }}
                        </span>

                        <div>
                            <span class="font-medium text-gray-700 text-xs block leading-tight">{{ $category->name }}</span>
                            @if($category->color)
                            <span class="inline-block w-2 h-2 rounded-full mt-0.5" style="background-color: {{ $category->color }}"></span>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-4 py-2.5 hidden sm:table-cell">
                    <code class="text-[10px] text-gray-400 font-mono">{{ $category->slug }}</code>
                </td>
                <td class="px-4 py-2.5 hidden md:table-cell">
                    <div class="flex items-center gap-1.5">
                        <span class="text-base leading-none">{{ $category->parent?->icon }}</span>
                        <span class="text-gray-500 text-xs">{{ $category->parent?->name ?? '—' }}</span>
                    </div>
                </td>
                <td class="px-4 py-2.5 text-center">
                    @if($category->is_active)
                        <span class="inline-block w-1.5 h-1.5 rounded-full bg-green-500 mx-auto"></span>
                    @else
                        <span class="inline-block w-1.5 h-1.5 rounded-full bg-gray-300 mx-auto"></span>
                    @endif
                </td>
                <td class="px-4 py-2.5 text-center hidden lg:table-cell">
                    <span class="text-gray-400 font-mono text-xs">{{ $category->sort_order }}</span>
                </td>
                <td class="px-4 py-2.5 text-right">
                    <div class="flex items-center justify-end gap-1.5 opacity-0 group-hover:opacity-100 transition">
                        <a href="{{ route('admin.categories.edit', $category) }}"
                           class="inline-flex items-center justify-center w-6 h-6 rounded-md text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition"
                           title="{{ __t('button.edit') }}">
                            <i class="fas fa-pencil-alt text-xs"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                              data-confirm="{{ __t('admin.confirm_delete') }}">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center justify-center w-6 h-6 rounded-md text-gray-400 hover:text-red-600 hover:bg-red-50 transition"
                                    title="{{ __t('button.delete') }}">
                                <i class="fas fa-trash-alt text-xs"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endif

            @empty
            <tr>
                <td colspan="6" class="px-4 py-12 text-center">
                    <div class="flex flex-col items-center gap-2 text-gray-400">
                        <i class="fas fa-tags text-3xl opacity-20"></i>
                        <span class="text-xs">{{ __t('admin.no_categories') }}</span>
                        <a href="{{ route('admin.categories.create') }}"
                           class="mt-1 text-xs text-green-600 hover:text-green-700 font-medium">
                            + {{ __t('admin.add_category') }}
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($categories->hasPages())
    <div class="px-4 py-3 border-t border-gray-100 bg-gray-50/50">
        {{ $categories->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
