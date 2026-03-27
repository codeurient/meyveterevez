@extends('admin.layouts.admin')

@section('title', __t('admin.add_blog_post'))
@section('breadcrumb', __t('admin.panel') . ' / ' . __t('admin.nav_blog_posts') . ' / ' . __t('admin.add_blog_post'))

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl border border-gray-100 p-6">
        <form method="POST" action="{{ route('admin.blog-posts.store') }}" class="space-y-4">
            @csrf

            {{-- Title (bilingual) --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('admin.col_title') }}</label>
                <div class="space-y-2">
                    @foreach(['az' => 'AZ 🇦🇿', 'en' => 'EN 🇬🇧'] as $locale => $flag)
                    <div class="flex items-center gap-2">
                        <span class="w-12 text-xs font-bold text-gray-500 shrink-0">{{ $flag }}</span>
                        <input type="text" name="title_translations[{{ $locale }}]"
                               value="{{ old('title_translations.' . $locale) }}"
                               {{ $locale === 'az' ? 'required' : '' }}
                               class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition {{ $errors->has('title_translations.' . $locale) ? 'border-red-300' : '' }}"
                               placeholder="{{ $locale === 'az' ? 'Yay meyvələrinin faydaları' : 'Benefits of summer fruits' }}">
                    </div>
                    @endforeach
                </div>
                @error('title_translations.az') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Slug --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                    {{ __t('admin.col_slug') }}
                    <span class="text-gray-400 font-normal">({{ __t('label.optional') }})</span>
                </label>
                <input type="text" name="slug" value="{{ old('slug') }}"
                       class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs font-mono focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition {{ $errors->has('slug') ? 'border-red-300' : '' }}"
                       placeholder="yay-meyvelerin-faydalari">
                @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Excerpt (bilingual) --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                    {{ __t('admin.col_excerpt') }}
                    <span class="text-gray-400 font-normal">({{ __t('label.optional') }})</span>
                </label>
                <div class="space-y-2">
                    @foreach(['az' => 'AZ 🇦🇿', 'en' => 'EN 🇬🇧'] as $locale => $flag)
                    <div class="flex items-start gap-2">
                        <span class="w-12 text-xs font-bold text-gray-500 shrink-0 pt-2">{{ $flag }}</span>
                        <textarea name="excerpt_translations[{{ $locale }}]" rows="2" maxlength="500"
                                  class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition">{{ old('excerpt_translations.' . $locale) }}</textarea>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Content (bilingual) --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ __t('admin.col_content') }}</label>
                <div class="space-y-2">
                    @foreach(['az' => 'AZ 🇦🇿', 'en' => 'EN 🇬🇧'] as $locale => $flag)
                    <div class="flex items-start gap-2">
                        <span class="w-12 text-xs font-bold text-gray-500 shrink-0 pt-2">{{ $flag }}</span>
                        <textarea name="content_translations[{{ $locale }}]" rows="10"
                                  {{ $locale === 'az' ? 'required' : '' }}
                                  class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition font-mono {{ $errors->has('content_translations.' . $locale) ? 'border-red-300' : '' }}">{{ old('content_translations.' . $locale) }}</textarea>
                    </div>
                    @endforeach
                </div>
                @error('content_translations.az') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Publish controls --}}
            <div class="grid grid-cols-2 gap-3 pt-1">
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_published" id="is_published" value="1"
                           {{ old('is_published') ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                    <label for="is_published" class="text-xs text-gray-600 cursor-pointer font-medium">
                        {{ __t('admin.publish_post') }}
                    </label>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">
                        {{ __t('admin.col_published_at') }}
                        <span class="text-gray-400 font-normal">({{ __t('label.optional') }})</span>
                    </label>
                    <input type="datetime-local" name="published_at" value="{{ old('published_at') }}"
                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-green-500 bg-gray-50 focus:bg-white transition">
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-4 py-2 rounded-lg transition">
                    {{ __t('button.save') }}
                </button>
                <a href="{{ route('admin.blog-posts.index') }}"
                   class="text-xs text-gray-500 hover:text-gray-700 transition">
                    {{ __t('button.cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
