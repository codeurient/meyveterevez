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
    /**
     * @param array<string,string> $replace  e.g. ['count' => '5'] replaces :count in the value
     */
    function __t(string $key, array $replace = [], ?string $locale = null): string
    {
        try {
            $value = app(TranslationService::class)->get($key, $locale);
        } catch (\Throwable) {
            $value = $key;
        }

        foreach ($replace as $placeholder => $replacement) {
            $value = str_replace(':' . $placeholder, (string) $replacement, $value);
        }

        return $value;
    }
}
