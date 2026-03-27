<?php

declare(strict_types=1);

namespace App\Actions\Admin\Locale;

use App\DTOs\Admin\LocaleDTO;
use App\Models\Locale;

final class CreateLocaleAction
{
    public function execute(LocaleDTO $dto): Locale
    {
        if ($dto->isDefault) {
            Locale::where('is_default', true)->update(['is_default' => false]);
        }

        return Locale::create([
            'code'        => $dto->code,
            'name'        => $dto->name,
            'native_name' => $dto->nativeName,
            'flag'        => $dto->flag,
            'dir'         => $dto->dir,
            'sort_order'  => $dto->sortOrder,
            'is_active'   => $dto->isActive,
            'is_default'  => $dto->isDefault,
        ]);
    }
}
