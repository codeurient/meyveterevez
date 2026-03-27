<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = [
        'title',
        'title_translations',
        'slug',
        'excerpt',
        'excerpt_translations',
        'content',
        'content_translations',
        'featured_image_path',
        'read_time',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'title_translations'   => 'array',
        'excerpt_translations' => 'array',
        'content_translations' => 'array',
        'is_published'         => 'boolean',
        'published_at'         => 'datetime',
    ];

    // ── Scopes ────────────────────────────────────────────────

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    // ── Accessors ─────────────────────────────────────────────

    public function getTranslatedTitleAttribute(): string
    {
        $locale = app()->getLocale();
        return $this->title_translations[$locale]
            ?? $this->title_translations['az']
            ?? $this->title;
    }

    public function getTranslatedExcerptAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $this->excerpt_translations[$locale]
            ?? $this->excerpt_translations['az']
            ?? $this->excerpt;
    }

    public function getTranslatedContentAttribute(): string
    {
        $locale = app()->getLocale();
        return $this->content_translations[$locale]
            ?? $this->content_translations['az']
            ?? $this->content;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
