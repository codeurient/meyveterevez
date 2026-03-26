@extends('layouts.app')

@section('title', __t('heading.popular_stores'))
@section('description', __t('heading.popular_stores_desc'))

@section('content')

    {{-- ==================== PAGE HEADER ==================== --}}
    <section class="bg-white border-b border-gray-100 py-4">
        <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h1 class="font-montserrat font-bold text-xl md:text-2xl text-gray-800">{{ __t('heading.popular_stores') }}</h1>
                    <p class="text-gray-500 text-sm mt-0.5">{{ __t('heading.popular_stores_desc') }}</p>
                </div>
                <nav class="text-sm text-gray-500 flex items-center gap-2">
                    <a href="{{ route('home') }}" class="hover:text-green-600 transition">{{ __t('breadcrumb.home') }}</a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span class="text-gray-800 font-medium">{{ __t('nav.stores') }}</span>
                </nav>
            </div>
        </div>
    </section>

    <div class="max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <div class="flex items-center justify-between mb-5">
            <p class="text-sm text-gray-500">{{ $stores->total() }} {{ __t('label.stores_found') }}</p>
        </div>

        @if($stores->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                @foreach($stores as $store)
                    <x-ui.store-card :store="$store" />
                @endforeach
            </div>

            @if($stores->hasPages())
                <div class="mt-10 flex justify-center">{{ $stores->links() }}</div>
            @endif
        @else
            <div class="text-center py-24 text-gray-400">
                <i class="fas fa-store text-4xl mb-4 block text-gray-300"></i>
                <p>{{ __t('search.no_results') }}</p>
            </div>
        @endif
    </div>

@endsection
