<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name'         => ['required', 'string', 'max:100'],
            'last_name'          => ['required', 'string', 'max:100'],
            'email'              => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone_country_code' => ['nullable', 'string', 'max:10', 'exists:phone_country_codes,code'],
            'phone'              => ['nullable', 'string', 'max:30'],
            'location_id'        => ['nullable', 'integer', 'exists:locations,id'],
            'password'           => ['required', 'confirmed', Password::min(8)],
        ];
    }
}
