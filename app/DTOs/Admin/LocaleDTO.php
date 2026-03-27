<?php

declare(strict_types=1);

namespace App\DTOs\Admin;

use App\Http\Requests\Admin\StoreLocaleRequest;
use App\Http\Requests\Admin\UpdateLocaleRequest;

final class LocaleDTO
{
    public function __construct(
        public readonly string  $code,
        public readonly string  $name,
        public readonly ?string $nativeName,
        public readonly ?string $flag,
        public readonly string  $dir,
        public readonly int     $sortOrder,
        public readonly bool    $isActive,
        public readonly bool    $isDefault,
    ) {}

    public static function fromRequest(StoreLocaleRequest|UpdateLocaleRequest $request): self
    {
        return new self(
            code:       $request->validated('code'),
            name:       $request->validated('name'),
            nativeName: $request->validated('native_name'),
            flag:       $request->validated('flag'),
            dir:        $request->validated('dir', 'ltr'),
            sortOrder:  (int) $request->validated('sort_order', 0),
            isActive:   (bool) $request->validated('is_active', true),
            isDefault:  (bool) $request->validated('is_default', false),
        );
    }
}
