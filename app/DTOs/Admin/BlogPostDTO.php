<?php

declare(strict_types=1);

namespace App\DTOs\Admin;

use App\Http\Requests\Admin\StoreBlogPostRequest;
use App\Http\Requests\Admin\UpdateBlogPostRequest;
use Carbon\Carbon;
use Illuminate\Support\Str;

final class BlogPostDTO
{
    public function __construct(
        public readonly array   $titleTranslations,
        public readonly string  $title,
        public readonly string  $slug,
        public readonly array   $excerptTranslations,
        public readonly ?string $excerpt,
        public readonly array   $contentTranslations,
        public readonly string  $content,
        public readonly ?string $featuredImagePath,
        public readonly int     $readTime,
        public readonly bool    $isPublished,
        public readonly ?Carbon $publishedAt,
    ) {}

    public static function fromRequest(
        StoreBlogPostRequest|UpdateBlogPostRequest $request,
        ?string $existingImagePath = null,
    ): self {
        $titleTranslations   = (array) $request->validated('title_translations', []);
        $title               = $titleTranslations['az'] ?? $titleTranslations['en'] ?? '';

        $slug = filled($request->validated('slug'))
            ? $request->validated('slug')
            : Str::slug($title);

        $excerptTranslations = (array) $request->validated('excerpt_translations', []);
        $excerpt             = $excerptTranslations['az'] ?? $excerptTranslations['en'] ?? null;

        $contentTranslations = (array) $request->validated('content_translations', []);
        $content             = $contentTranslations['az'] ?? $contentTranslations['en'] ?? '';

        $isPublished = (bool) $request->validated('is_published', false);

        // Auto-calculate read time from AZ content (~200 words/min)
        $wordCount = str_word_count(strip_tags($content));
        $readTime  = max(1, (int) ceil($wordCount / 200));

        $publishedAt = $isPublished
            ? ($request->validated('published_at')
                ? Carbon::parse($request->validated('published_at'))
                : now())
            : null;

        return new self(
            titleTranslations:   $titleTranslations,
            title:               $title,
            slug:                $slug,
            excerptTranslations: $excerptTranslations,
            excerpt:             filled($excerpt) ? $excerpt : null,
            contentTranslations: $contentTranslations,
            content:             $content,
            featuredImagePath:   $existingImagePath,
            readTime:            $readTime,
            isPublished:         $isPublished,
            publishedAt:         $publishedAt,
        );
    }
}
