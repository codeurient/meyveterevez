<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneCountryCode extends Model
{
    protected $primaryKey = 'code';
    protected $keyType    = 'string';
    public    $incrementing = false;

    protected $fillable = [
        'code',
        'name',
        'name_translations',
        'native_name',
        'phone_code',
        'trunk_prefix',
        'idd_prefix',
        'is_active',
    ];

    protected $casts = [
        'is_active'         => 'boolean',
        'name_translations' => 'array',
    ];

    // ── Translation ────────────────────────────────────────────

    /** Returns name in current app locale, falls back to English name. */
    public function getTranslatedNameAttribute(): string
    {
        $locale = app()->getLocale();
        return $this->name_translations[$locale]
            ?? $this->name_translations['en']
            ?? $this->name;
    }

    // ── Scopes ─────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ── Helpers ────────────────────────────────────────────────

    /** Display label used in select dropdowns: "+994 (AZ)" */
    public function getDisplayLabelAttribute(): string
    {
        return "{$this->phone_code} ({$this->code}) {$this->name}";
    }
}
