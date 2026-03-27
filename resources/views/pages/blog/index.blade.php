@extends('layouts.app')

@section('title', __t('nav.blog') . ' — MeyveTerevez')
@section('meta_description', __t('heading.blog'))

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 sm:px-6">

    {{-- Page header --}}
    <div class="mb-8">
        <h1 class="text-xl font-bold text-gray-900 sm:text-2xl">{{ __t('nav.blog') }}</h1>
        <p class="text-sm text-gray-500 mt-1">{{ __t('heading.blog') }}</p>
    </div>

    @if($posts->isEmpty())
        <div class="py-20 text-center text-gray-400">
            <i class="fas fa-newspaper text-4xl mb-4 block text-gray-200"></i>
            <p class="text-sm">{{ __t('heading.no_posts_yet') }}</p>
        </div>
    @else
        {{-- Post grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($posts as $post)
            <article class="bg-white rounded-xl border border-gray-100 overflow-hidden hover:shadow-md transition group">
                {{-- Thumbnail placeholder --}}
                <div class="h-36 bg-gradient-to-br from-green-50 to-emerald-100 flex items-center justify-center">
                    <i class="fas fa-newspaper text-3xl text-green-200"></i>
                </div>

                <div class="p-4">
                    {{-- Meta --}}
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xs text-gray-400">
                            {{ $post->published_at?->format('d M Y') }}
                        </span>
                        @if($post->read_time)
                            <span class="text-gray-200">·</span>
                            <span class="text-xs text-gray-400">{{ $post->read_time }} {{ __t('label.min_read') }}</span>
                        @endif
                    </div>

                    {{-- Title --}}
                    <h2 class="font-semibold text-gray-900 text-sm leading-snug mb-2 group-hover:text-green-700 transition line-clamp-2">
                        <a href="{{ route('blog.show', $post) }}">
                            {{ $post->translated_title }}
                        </a>
                    </h2>

                    {{-- Excerpt --}}
                    @if($post->translated_excerpt)
                        <p class="text-xs text-gray-500 leading-relaxed line-clamp-3 mb-3">
                            {{ $post->translated_excerpt }}
                        </p>
                    @endif

                    <a href="{{ route('blog.show', $post) }}"
                       class="inline-flex items-center gap-1 text-xs font-semibold text-green-600 hover:text-green-700 transition">
                        {{ __t('label.read_more') }}
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($posts->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $posts->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
