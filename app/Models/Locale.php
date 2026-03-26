<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Locale extends Model
{
    protected $primaryKey = 'code';
    public    $incrementing = false;
    protected $keyType      = 'string';

    protected $fillable = [
        'code',
        'name',
        'flag',
        'is_active',
        'is_default',
        'sort_order',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'is_default' => 'boolean',
        'sort_order' => 'integer',
    ];

    // ── Relationships ──────────────────────────────────────────

    public function translations(): HasMany
    {
        return $this->hasMany(Translation::class, 'locale_code', 'code');
    }

    // ── Scopes ────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    // ── Helpers ───────────────────────────────────────────────

    /** Returns all active locales, cached for 1 hour. */
    public static function allActive(): Collection
    {
        return Cache::remember('locales.active', 3600, fn () =>
            static::active()->get()
        );
    }

    /** Returns the default locale code, cached. */
    public static function defaultCode(): string
    {
        return Cache::remember('locales.default', 3600, fn () =>
            static::where('is_default', true)->value('code') ?? 'az'
        );
    }

    /** Returns all active locale codes. */
    public static function activeCodes(): array
    {
        return static::allActive()->pluck('code')->all();
    }
}
