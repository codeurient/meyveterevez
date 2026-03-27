<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'name_translations',
        'type',
        'code',
        'latitude',
        'longitude',
        'is_active',
    ];

    protected $casts = [
        'latitude'         => 'float',
        'longitude'        => 'float',
        'is_active'        => 'boolean',
        'name_translations' => 'array',
    ];

    // ── Translation ────────────────────────────────────────────

    /** Returns name in current app locale, falls back to 'name' column. */
    public function getTranslatedNameAttribute(): string
    {
        $locale = app()->getLocale();
        return $this->name_translations[$locale]
            ?? $this->name_translations['en']
            ?? $this->name;
    }

    // ── Relationships ──────────────────────────────────────────

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Location::class, 'parent_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'location_id');
    }

    // ── Scopes ────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCountries($query)
    {
        return $query->where('type', 'country');
    }

    public function scopeCities($query)
    {
        return $query->where('type', 'city');
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    // ── Helpers ───────────────────────────────────────────────

    public function isCountry(): bool
    {
        return $this->type === 'country';
    }

    public function isCity(): bool
    {
        return $this->type === 'city';
    }

    /** Returns country name for a city (traverses parent chain). */
    public function countryName(): string
    {
        if ($this->isCountry()) {
            return $this->name;
        }

        return $this->parent?->countryName() ?? '';
    }

    /** Get cities for a given country id. */
    public static function citiesForCountry(int $countryId): Collection
    {
        return static::where('parent_id', $countryId)
            ->where('type', 'city')
            ->active()
            ->orderBy('name')
            ->get();
    }
}
