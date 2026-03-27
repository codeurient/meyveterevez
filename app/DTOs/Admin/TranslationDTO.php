<?php

declare(strict_types=1);

namespace App\DTOs\Admin;

use App\Http\Requests\Admin\StoreTranslationRequest;
use App\Http\Requests\Admin\UpdateTranslationRequest;

final class TranslationDTO
{
    public function __construct(
        public readonly string $key,
        public readonly string $locale,
        public readonly string $group,
        public readonly string $value,
        public readonly bool   $isActive,
    ) {}

    public static function fromRequest(StoreTranslationRequest|UpdateTranslationRequest $request): self
    {
        return new self(
            key:      $request->validated('key'),
            locale:   $request->validated('locale'),
            group:    $request->validated('group'),
            value:    $request->validated('value'),
            isActive: (bool) $request->validated('is_active', true),
        );
    }
}
