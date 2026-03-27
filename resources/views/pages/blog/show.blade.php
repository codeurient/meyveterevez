@extends('layouts.app')

@section('title', $blogPost->translated_title . ' — MeyveTerevez')
@section('meta_description', $blogPost->translated_excerpt ?? '')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8 sm:px-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-xs text-gray-400 mb-6">
        <a href="{{ route('home') }}" class="hover:text-gray-600 transition">{{ __t('nav.home') }}</a>
        <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
        <a href="{{ route('blog.index') }}" class="hover:text-gray-600 transition">{{ __t('nav.blog') }}</a>
        <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
        <span class="text-gray-600 truncate max-w-48">{{ $blogPost->translated_title }}</span>
    </nav>

    {{-- Article --}}
    <article>
        {{-- Header --}}
        <header class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 leading-snug sm:text-3xl">
                {{ $blogPost->translated_title }}
            </h1>

            <div class="flex items-center gap-3 mt-3 text-xs text-gray-400">
                @if($blogPost->published_at)
                    <span class="flex items-center gap-1">
                        <i class="fas fa-calendar-alt text-gray-300"></i>
                        {{ $blogPost->published_at->format('d M Y') }}
                    </span>
                @endif
                @if($blogPost->read_time)
                    <span class="text-gray-300">·</span>
                    <span class="flex items-center gap-1">
                        <i class="fas fa-clock text-gray-300"></i>
                        {{ $blogPost->read_time }} {{ __t('label.min_read') }}
                    </span>
                @endif
            </div>

            @if($blogPost->translated_excerpt)
                <p class="mt-4 text-sm text-gray-600 leading-relaxed border-l-4 border-green-200 pl-4">
                    {{ $blogPost->translated_excerpt }}
                </p>
            @endif
        </header>

        {{-- Content --}}
        <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
            {!! nl2br(e($blogPost->translated_content)) !!}
        </div>
    </article>

    {{-- Back link --}}
    <div class="mt-10 pt-6 border-t border-gray-100">
        <a href="{{ route('blog.index') }}"
           class="inline-flex items-center gap-2 text-xs font-semibold text-green-600 hover:text-green-700 transition">
            <i class="fas fa-arrow-left text-xs"></i>
            {{ __t('nav.blog') }}
        </a>
    </div>

    {{-- Related posts --}}
    @if($related->isNotEmpty())
        <div class="mt-10">
            <h2 class="text-sm font-bold text-gray-800 mb-4">{{ __t('heading.latest_posts') }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach($related as $post)
                <a href="{{ route('blog.show', $post) }}"
                   class="block p-3 bg-white rounded-xl border border-gray-100 hover:shadow-sm hover:border-green-200 transition group">
                    <p class="text-xs text-gray-400 mb-1">{{ $post->published_at?->format('d M Y') }}</p>
                    <h3 class="text-xs font-semibold text-gray-800 group-hover:text-green-700 transition line-clamp-3 leading-snug">
                        {{ $post->translated_title }}
                    </h3>
                </a>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
