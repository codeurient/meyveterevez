@extends('admin.layouts.admin')

@section('title', __t('admin.nav_products'))
@section('breadcrumb', __t('admin.panel') . ' / ' . __t('admin.nav_products'))

@section('content')
<div class="flex items-center justify-between mb-4">
    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.products.index') }}" class="flex items-center gap-2">
        <select name="category_id" onchange="this.form.submit()"
                class="px-3 py-1.5 border border-gray-200 rounded-lg text-xs bg-white focus:outline-none focus:ring-2 focus:ring-green-500">
            <option value="">{{ __t('admin.all_categories') }}</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->icon }} {{ $cat->name }}
                </option>
            @endforeach
        </select>
        <select name="status" onchange="this.form.submit()"
                class="px-3 py-1.5 border border-gray-200 rounded-lg text-xs bg-white focus:outline-none focus:ring-2 focus:ring-green-500">
            <option value="">{{ __t('admin.all_statuses') }}</option>
            <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>{{ __t('admin.status_active') }}</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>{{ __t('admin.status_inactive') }}</option>
            <option value="draft"    {{ request('status') === 'draft'    ? 'selected' : '' }}>{{ __t('admin.status_draft') }}</option>
        </select>
        <div class="relative">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="{{ __t('placeholder.search') }}"
                   class="pl-7 pr-3 py-1.5 border border-gray-200 rounded-lg text-xs bg-white focus:outline-none focus:ring-2 focus:ring-green-500 w-48">
            <i class="fas fa-search absolute left-2 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
        </div>
    </form>
    <a href="{{ route('admin.products.create') }}"
       class="flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
        <i class="fas fa-plus text-xs"></i>
        {{ __t('admin.add_product') }}
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
    <table class="w-full text-xs">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500 w-10"></th>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500">{{ __t('label.name') }}</th>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_category') }}</th>
                <th class="text-left px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_store') }}</th>
                <th class="text-right px-4 py-2.5 font-semibold text-gray-500">{{ __t('label.price') }}</th>
                <th class="text-center px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_flags') }}</th>
                <th class="text-center px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_status') }}</th>
                <th class="text-right px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_actions') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($products as $product)
            <tr class="hover:bg-gray-50/50 transition">
                <td class="px-4 py-2.5">
                    @if($product->primaryImage)
                        <img src="{{ $product->primaryImage->thumbnail_path }}"
                             alt="{{ $product->name }}"
                             class="w-8 h-8 rounded-lg object-cover">
                    @else
                        <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-300">
                            <i class="fas fa-image text-xs"></i>
                        </div>
                    @endif
                </td>
                <td class="px-4 py-2.5">
                    <p class="font-medium text-gray-800">{{ $product->name }}</p>
                    <p class="text-gray-400 font-mono">{{ $product->slug }}</p>
                </td>
                <td class="px-4 py-2.5 text-gray-600">
                    {{ $product->category?->icon }} {{ $product->category?->name ?? '—' }}
                </td>
                <td class="px-4 py-2.5 text-gray-600">{{ $product->storeProfile?->name ?? '—' }}</td>
                <td class="px-4 py-2.5 text-right">
                    <p class="font-semibold text-gray-800">{{ number_format($product->price, 2) }} ₼</p>
                    @if($product->discount_percent)
                        <p class="text-green-600 font-medium">-{{ $product->discount_percent }}%</p>
                    @endif
                </td>
                <td class="px-4 py-2.5 text-center">
                    <div class="flex items-center justify-center gap-1">
                        @if($product->is_organic)
                            <span class="w-4 h-4 rounded bg-green-100 text-green-600 flex items-center justify-center" title="{{ __t('label.organic') }}">🌱</span>
                        @endif
                        @if($product->is_fresh_today)
                            <span class="w-4 h-4 rounded bg-blue-100 text-blue-600 flex items-center justify-center" title="{{ __t('label.fresh_today') }}">✨</span>
                        @endif
                        @if($product->is_featured)
                            <span class="w-4 h-4 rounded bg-yellow-100 text-yellow-600 flex items-center justify-center" title="{{ __t('label.featured') }}">⭐</span>
                        @endif
                    </div>
                </td>
                <td class="px-4 py-2.5 text-center">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                        {{ $product->status === 'active' ? 'bg-green-50 text-green-700' : ($product->status === 'draft' ? 'bg-amber-50 text-amber-700' : 'bg-gray-100 text-gray-500') }}">
                        {{ __t('admin.status_' . $product->status) }}
                    </span>
                </td>
                <td class="px-4 py-2.5 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.products.edit', $product) }}"
                           class="text-gray-400 hover:text-blue-600 transition" title="{{ __t('button.edit') }}">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
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
                <td colspan="8" class="px-4 py-8 text-center text-gray-400">
                    <i class="fas fa-box-open text-2xl mb-2 block opacity-30"></i>
                    {{ __t('admin.no_products') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($products->hasPages())
    <div class="px-4 py-3 border-t border-gray-100">
        {{ $products->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
