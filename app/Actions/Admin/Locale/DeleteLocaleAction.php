<?php

declare(strict_types=1);

namespace App\Actions\Admin\Locale;

use App\Models\Locale;
use Illuminate\Validation\ValidationException;

final class DeleteLocaleAction
{
    public function execute(Locale $locale): void
    {
        if ($locale->is_default) {
            throw ValidationException::withMessages([
                'locale' => [__t('admin.locale_delete_default_error')],
            ]);
        }

        $locale->delete();
    }
}
