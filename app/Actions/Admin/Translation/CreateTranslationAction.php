<?php

declare(strict_types=1);

namespace App\Actions\Admin\Translation;

use App\DTOs\Admin\TranslationDTO;
use App\Models\Translation;
use Illuminate\Support\Facades\Cache;

final class CreateTranslationAction
{
    public function execute(TranslationDTO $dto): Translation
    {
        $translation = Translation::updateOrCreate(
            ['key' => $dto->key, 'locale' => $dto->locale],
            [
                'group'     => $dto->group,
                'value'     => $dto->value,
                'is_active' => $dto->isActive,
            ]
        );

        Cache::forget("translations.{$dto->locale}");

        return $translation;
    }
}
