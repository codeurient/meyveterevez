<?php

declare(strict_types=1);

namespace App\DTOs\Admin;

use App\Http\Requests\Admin\StorePhoneCodeRequest;
use App\Http\Requests\Admin\UpdatePhoneCodeRequest;

final readonly class PhoneCodeDTO
{
    public function __construct(
        public string  $code,
        public string  $name,
        public string  $nativeName,
        public string  $phoneCode,
        public ?string $trunkPrefix,
        public ?string $iddPrefix,
        public bool    $isActive,
    ) {}

    public static function fromRequest(StorePhoneCodeRequest|UpdatePhoneCodeRequest $request): self
    {
        return new self(
            code:        strtoupper($request->validated('code')),
            name:        $request->validated('name'),
            nativeName:  $request->validated('native_name'),
            phoneCode:   $request->validated('phone_code'),
            trunkPrefix: $request->validated('trunk_prefix'),
            iddPrefix:   $request->validated('idd_prefix'),
            isActive:    (bool) $request->validated('is_active', true),
        );
    }
}
