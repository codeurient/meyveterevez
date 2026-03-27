<?php

declare(strict_types=1);

namespace App\DTOs\Admin;

use App\Http\Requests\Admin\StoreLocationRequest;
use App\Http\Requests\Admin\UpdateLocationRequest;

final class LocationDTO
{
    public function __construct(
        public readonly string  $name,
        public readonly array   $nameTranslations,
        public readonly string  $type,
        public readonly ?int    $parentId,
        public readonly ?string $code,
        public readonly ?float  $latitude,
        public readonly ?float  $longitude,
        public readonly bool    $isActive,
    ) {}

    public static function fromRequest(StoreLocationRequest|UpdateLocationRequest $request): self
    {
        $translations = [];
        foreach ($request->validated('name_translations', []) as $locale => $value) {
            if (filled($value)) {
                $translations[$locale] = $value;
            }
        }

        return new self(
            name:             $translations['en'] ?? $request->validated('name'),
            nameTranslations: $translations,
            type:             $request->validated('type'),
            parentId:         $request->validated('parent_id'),
            code:             $request->validated('code'),
            latitude:         $request->validated('latitude') !== null ? (float) $request->validated('latitude') : null,
            longitude:        $request->validated('longitude') !== null ? (float) $request->validated('longitude') : null,
            isActive:         (bool) $request->validated('is_active', true),
        );
    }
}
