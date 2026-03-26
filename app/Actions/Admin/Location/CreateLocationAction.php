<?php

declare(strict_types=1);

namespace App\Actions\Admin\Location;

use App\DTOs\Admin\LocationDTO;
use App\Models\Location;

final class CreateLocationAction
{
    public function execute(LocationDTO $dto): Location
    {
        return Location::create([
            'name'      => $dto->name,
            'type'      => $dto->type,
            'parent_id' => $dto->parentId,
            'code'      => $dto->code,
            'latitude'  => $dto->latitude,
            'longitude' => $dto->longitude,
            'is_active' => $dto->isActive,
        ]);
    }
}
