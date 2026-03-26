@extends('layouts.app')

@section('title', __t('nav.categories'))
@section('description', __t('heading.all_products_desc'))

@section('content')

    {{-- ==================== PAGE HEADER ==================== --}}
    <section class="bg-white border-b border-gray-100 py-4">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h1 class="font-montserrat font-bold text-xl md:text-2xl text-gray-800">{{ __t('nav.categories') }}</h1>
                    <p class="text-gray-500 text-sm mt-0.5">{{ __t('heading.shop_by_category') }}</p>
                </div>
                <nav class="text-sm text-gray-500 flex items-center gap-2">
                    <a href="{{ route('home') }}" class="hover:text-green-600 transition">{{ __t('breadcrumb.home') }}</a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span class="text-gray-800 font-medium">{{ __t('nav.categories') }}</span>
                </nav>
            </div>
        </div>
    </section>

    <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Root Categories --}}
        @if($categories->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-10">
                @foreach($categories as $category)
                    <a href="{{ route('categories.show', $category->slug) }}"
                       class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col items-center gap-3 hover:shadow-md hover:border-green-200 transition group">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl transition-transform group-hover:scale-110"
                             style="background-color: {{ $category->color ? $category->color . '20' : '#f0fdf4' }}; border: 2px solid {{ $category->color ?? '#22C55E' }}30;">
                            {{ $category->icon ?? '🛒' }}
                        </div>
                        <div class="text-center">
                            <h3 class="font-bold text-sm text-gray-800 leading-tight">{{ $category->name }}</h3>
                            @if($category->children_count > 0)
                                <p class="text-xs text-gray-400 mt-0.5">{{ $category->children_count }} {{ __t('label.subcategories') }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Categories with Sub-categories --}}
        @foreach($categories as $category)
            @if($category->children && $category->children->count() > 0)
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl"
                                 style="background-color: {{ $category->color ? $category->color . '20' : '#f0fdf4' }};">
                                {{ $category->icon ?? '🛒' }}
                            </div>
                            <h2 class="font-montserrat font-bold text-lg text-gray-800">{{ $category->name }}</h2>
                        </div>
                        <a href="{{ route('categories.show', $category->slug) }}"
                           class="text-green-600 text-sm font-semibold hover:text-green-700 flex items-center gap-1">
                            {{ __t('button.view_all') }} <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-3">
                        @foreach($category->children as $child)
                            <a href="{{ route('categories.show', $child->slug) }}"
                               class="bg-white rounded-xl border border-gray-100 p-3 flex flex-col items-center gap-2 hover:border-green-300 hover:shadow-sm transition text-center group">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center text-xl"
                                     style="background-color: {{ $child->color ? $child->color . '20' : ($category->color ? $category->color . '15' : '#f0fdf4') }};">
                                    {{ $child->icon ?? '🛒' }}
                                </div>
                                <span class="text-xs font-semibold text-gray-700 leading-tight group-hover:text-green-600 transition">{{ $child->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach

    </div>

@endsection
