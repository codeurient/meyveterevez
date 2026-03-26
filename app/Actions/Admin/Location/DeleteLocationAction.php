<?php

declare(strict_types=1);

namespace App\Actions\Admin\Location;

use App\Models\Location;
use Illuminate\Validation\ValidationException;

final class DeleteLocationAction
{
    public function execute(Location $location): void
    {
        if ($location->children()->count() > 0) {
            throw ValidationException::withMessages([
                'location' => [__t('admin.location_has_children')],
            ]);
        }

        if ($location->users()->count() > 0) {
            throw ValidationException::withMessages([
                'location' => [__t('admin.location_has_users')],
            ]);
        }

        $location->delete();
    }
}
