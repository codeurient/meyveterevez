<?php

declare(strict_types=1);

use App\Services\TranslationService;

if (! function_exists('__t')) {
    /**
     * Translate a dot-notation key using the database-driven TranslationService.
     *
     * Usage in Blade:  {{ __t('nav.home') }}
     * Usage in PHP:    __t('button.add_to_cart')
     *
     * Falls back to the key itself if no translation is found — never crashes.
     */
    function __t(string $key, ?string $locale = null): string
    {
        try {
            return app(TranslationService::class)->get($key, $locale);
        } catch (\Throwable) {
            // DB not yet migrated or service unavailable — show the key
            return $key;
        }
    }
}
