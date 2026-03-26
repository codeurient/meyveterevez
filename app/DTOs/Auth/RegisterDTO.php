<?php

declare(strict_types=1);

namespace App\DTOs\Auth;

use App\Http\Requests\Auth\RegisterRequest;

final readonly class RegisterDTO
{
    public function __construct(
        public string  $firstName,
        public string  $lastName,
        public string  $email,
        public string  $password,
        public ?string $phone = null,
    ) {}

    public static function fromRequest(RegisterRequest $request): self
    {
        return new self(
            firstName: $request->validated('first_name'),
            lastName:  $request->validated('last_name'),
            email:     $request->validated('email'),
            password:  $request->validated('password'),
            phone:     $request->validated('phone'),
        );
    }
}
