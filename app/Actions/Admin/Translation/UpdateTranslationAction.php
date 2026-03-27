<?php

declare(strict_types=1);

namespace App\Actions\Admin\Translation;

use App\DTOs\Admin\TranslationDTO;
use App\Models\Translation;
use Illuminate\Support\Facades\Cache;

final class UpdateTranslationAction
{
    public function execute(Translation $translation, TranslationDTO $dto): Translation
    {
        $oldLocale = $translation->locale;

        $translation->update([
            'key'       => $dto->key,
            'locale'    => $dto->locale,
            'group'     => $dto->group,
            'value'     => $dto->value,
            'is_active' => $dto->isActive,
        ]);

        Cache::forget("translations.{$oldLocale}");

        if ($dto->locale !== $oldLocale) {
            Cache::forget("translations.{$dto->locale}");
        }

        return $translation->fresh();
    }
}
