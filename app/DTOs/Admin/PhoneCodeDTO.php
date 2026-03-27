<?php

declare(strict_types=1);

namespace App\DTOs\Admin;

use App\Http\Requests\Admin\StorePhoneCodeRequest;
use App\Http\Requests\Admin\UpdatePhoneCodeRequest;

final class PhoneCodeDTO
{
    public function __construct(
        public readonly string  $code,
        public readonly string  $name,
        public readonly array   $nameTranslations,
        public readonly string  $nativeName,
        public readonly string  $phoneCode,
        public readonly ?string $trunkPrefix,
        public readonly ?string $iddPrefix,
        public readonly bool    $isActive,
    ) {}

    public static function fromRequest(StorePhoneCodeRequest|UpdatePhoneCodeRequest $request): self
    {
        $translations = [];
        foreach ($request->validated('name_translations', []) as $locale => $value) {
            if (filled($value)) {
                $translations[$locale] = $value;
            }
        }

        return new self(
            code:             strtoupper($request->validated('code')),
            name:             $translations['en'] ?? $request->validated('name'),
            nameTranslations: $translations,
            nativeName:       $request->validated('native_name'),
            phoneCode:        $request->validated('phone_code'),
            trunkPrefix:      $request->validated('trunk_prefix'),
            iddPrefix:        $request->validated('idd_prefix'),
            isActive:         (bool) $request->validated('is_active', true),
        );
    }
}
