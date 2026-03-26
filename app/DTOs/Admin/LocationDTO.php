<?php

declare(strict_types=1);

namespace App\DTOs\Admin;

use App\Http\Requests\Admin\StoreLocationRequest;
use App\Http\Requests\Admin\UpdateLocationRequest;
use Illuminate\Foundation\Http\FormRequest;

final readonly class LocationDTO
{
    public function __construct(
        public string  $name,
        public string  $type,
        public ?int    $parentId,
        public ?string $code,
        public ?float  $latitude,
        public ?float  $longitude,
        public bool    $isActive,
    ) {}

    public static function fromRequest(StoreLocationRequest|UpdateLocationRequest $request): self
    {
        return new self(
            name:      $request->validated('name'),
            type:      $request->validated('type'),
            parentId:  $request->validated('parent_id'),
            code:      $request->validated('code'),
            latitude:  $request->validated('latitude') !== null ? (float) $request->validated('latitude') : null,
            longitude: $request->validated('longitude') !== null ? (float) $request->validated('longitude') : null,
            isActive:  (bool) $request->validated('is_active', true),
        );
    }
}
