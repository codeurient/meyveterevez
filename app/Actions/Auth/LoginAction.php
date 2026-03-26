<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

final class LoginAction
{
    /**
     * @throws ValidationException
     */
    public function execute(Request $request, string $email, string $password, bool $remember = false): void
    {
        if (! Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            throw ValidationException::withMessages([
                'email' => [__t('error.invalid_credentials')],
            ]);
        }

        $request->session()->regenerate();
    }
}
