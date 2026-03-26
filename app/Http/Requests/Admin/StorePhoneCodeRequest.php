<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePhoneCodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'code'         => ['required', 'string', 'max:10', 'unique:phone_country_codes,code', 'uppercase'],
            'name'         => ['required', 'string', 'max:100'],
            'native_name'  => ['required', 'string', 'max:100'],
            'phone_code'   => ['required', 'string', 'max:10'],
            'trunk_prefix' => ['nullable', 'string', 'max:5'],
            'idd_prefix'   => ['nullable', 'string', 'max:10'],
            'is_active'    => ['boolean'],
        ];
    }
}
