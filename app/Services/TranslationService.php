<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Translation;
use Illuminate\Support\Facades\Cache;

class TranslationService
{
    /**
     * Get a translation value for a dot-notation key (group.key).
     * Falls back to the key itself so the site never crashes on missing translations.
     */
    public function get(string $fullKey, ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $all    = $this->getAllForLocale($locale);

        return $all[$fullKey] ?? $fullKey;
    }

    /**
     * Return all active translations for a locale as a flat array:
     * ['nav.home' => 'Ana Səhifə', 'button.add_to_cart' => 'Səbətə əlavə et', ...]
     * Cached per locale for 1 hour. Cache cleared by TranslationSeeder on re-seed.
     */
    public function getAllForLocale(string $locale): array
    {
        return Cache::remember("translations.{$locale}", 3600, function () use ($locale) {
            return Translation::where('locale_code', $locale)
                ->where('is_active', true)
                ->get()
                ->mapWithKeys(fn ($t) => ["{$t->group}.{$t->key}" => $t->value])
                ->all();
        });
    }

    /** Clear cached translations for one or all locales. */
    public function clearCache(?string $locale = null): void
    {
        if ($locale) {
            Cache::forget("translations.{$locale}");
            return;
        }

        // Clear all locales
        foreach (['az', 'en'] as $code) {
            Cache::forget("translations.{$code}");
        }
    }
}
