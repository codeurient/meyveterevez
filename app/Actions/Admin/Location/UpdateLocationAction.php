<?php

declare(strict_types=1);

namespace App\Actions\Admin\Location;

use App\DTOs\Admin\LocationDTO;
use App\Models\Location;

final class UpdateLocationAction
{
    public function execute(Location $location, LocationDTO $dto): Location
    {
        $location->update([
            'name'              => $dto->name,
            'name_translations' => $dto->nameTranslations ?: null,
            'type'              => $dto->type,
            'parent_id'         => $dto->parentId,
            'code'              => $dto->code,
            'latitude'          => $dto->latitude,
            'longitude'         => $dto->longitude,
            'is_active'         => $dto->isActive,
        ]);

        return $location->refresh();
    }
}
