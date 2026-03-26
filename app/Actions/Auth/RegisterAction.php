<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\DTOs\Auth\RegisterDTO;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class RegisterAction
{
    public function execute(RegisterDTO $dto): User
    {
        $user = User::create([
            'first_name'  => $dto->firstName,
            'last_name'   => $dto->lastName,
            'email'       => $dto->email,
            'password'    => $dto->password,
            'phone'       => $dto->phone,
            'locale_code' => app()->getLocale(),
        ]);

        Auth::login($user);

        return $user;
    }
}
