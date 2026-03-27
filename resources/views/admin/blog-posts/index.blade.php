@extends('admin.layouts.admin')

@section('title', __t('admin.nav_blog_posts'))
@section('breadcrumb', __t('admin.panel') . ' / ' . __t('admin.nav_blog_posts'))

@section('content')
<div class="flex items-center justify-between mb-4">
    <div>
        <p class="text-xs text-gray-500">{{ $posts->total() }} {{ __t('admin.nav_blog_posts') }}</p>
    </div>
    <a href="{{ route('admin.blog-posts.create') }}"
       class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-3 py-2 rounded-lg transition">
        <i class="fas fa-plus text-xs"></i>
        {{ __t('admin.add_blog_post') }}
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
    @if($posts->isEmpty())
        <div class="py-16 text-center text-gray-400">
            <i class="fas fa-newspaper text-3xl mb-3 block text-gray-200"></i>
            <p class="text-xs">{{ __t('admin.no_blog_posts') }}</p>
            <a href="{{ route('admin.blog-posts.create') }}"
               class="inline-block mt-3 text-xs text-green-600 hover:text-green-700 font-semibold">
                {{ __t('admin.add_blog_post') }} →
            </a>
        </div>
    @else
        <table class="w-full text-xs">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50/60">
                    <th class="text-left px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_title') }}</th>
                    <th class="text-left px-4 py-2.5 font-semibold text-gray-500 hidden md:table-cell">{{ __t('admin.col_excerpt') }}</th>
                    <th class="text-center px-4 py-2.5 font-semibold text-gray-500">{{ __t('admin.col_published') }}</th>
                    <th class="text-left px-4 py-2.5 font-semibold text-gray-500 hidden lg:table-cell">{{ __t('admin.col_published_at') }}</th>
                    <th class="px-4 py-2.5"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($posts as $post)
                <tr class="group hover:bg-gray-50/50 transition">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                                <i class="fas fa-newspaper text-blue-400 text-xs"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800 leading-tight">
                                    {{ $post->title_translations['az'] ?? $post->title }}
                                </p>
                                @if(!empty($post->title_translations['en']))
                                    <p class="text-gray-400 text-xs mt-0.5 leading-tight">
                                        {{ $post->title_translations['en'] }}
                                    </p>
                                @endif
                                <p class="text-gray-400 font-mono mt-0.5">{{ $post->slug }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-500 hidden md:table-cell max-w-xs">
                        <p class="truncate">{{ $post->excerpt_translations['az'] ?? $post->excerpt }}</p>
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($post->is_published)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs bg-green-50 text-green-700 font-medium">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                {{ __t('label.published') }}
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs bg-amber-50 text-amber-700 font-medium">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                {{ __t('admin.status_draft') }}
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-400 hidden lg:table-cell">
                        {{ $post->published_at?->format('d M Y') ?? '—' }}
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition">
                            @if($post->is_published)
                                <a href="{{ route('blog.show', $post) }}" target="_blank"
                                   class="text-gray-400 hover:text-blue-500 transition" title="{{ __t('admin.view_site') }}">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            @endif
                            <a href="{{ route('admin.blog-posts.edit', $post) }}"
                               class="text-gray-400 hover:text-green-600 transition">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.blog-posts.destroy', $post) }}"
                                  onsubmit="return confirm('{{ __t('message.confirm_delete') }}')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-500 transition">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($posts->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">
                {{ $posts->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
