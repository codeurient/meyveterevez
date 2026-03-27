<?php

declare(strict_types=1);

namespace App\DTOs\Auth;

use App\Http\Requests\Auth\RegisterRequest;

final class RegisterDTO
{
    public function __construct(
        public readonly string  $firstName,
        public readonly string  $lastName,
        public readonly string  $email,
        public readonly string  $password,
        public readonly ?string $phone = null,
        public readonly ?string $phoneCountryCode = null,
        public readonly ?int    $locationId = null,
    ) {}

    public static function fromRequest(RegisterRequest $request): self
    {
        return new self(
            firstName:        $request->validated('first_name'),
            lastName:         $request->validated('last_name'),
            email:            $request->validated('email'),
            password:         $request->validated('password'),
            phone:            $request->validated('phone'),
            phoneCountryCode: $request->validated('phone_country_code'),
            locationId:       $request->validated('location_id') ? (int) $request->validated('location_id') : null,
        );
    }
}
