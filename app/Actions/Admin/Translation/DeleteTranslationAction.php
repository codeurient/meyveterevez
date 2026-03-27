<?php

declare(strict_types=1);

namespace App\Actions\Admin\Translation;

use App\Models\Translation;
use Illuminate\Support\Facades\Cache;

final class DeleteTranslationAction
{
    public function execute(Translation $translation): void
    {
        $locale = $translation->locale;

        $translation->delete();

        Cache::forget("translations.{$locale}");
    }
}
