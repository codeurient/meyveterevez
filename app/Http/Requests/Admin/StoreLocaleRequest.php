<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'code'        => ['required', 'string', 'max:5', 'unique:locales,code'],
            'name'        => ['required', 'string', 'max:100'],
            'native_name' => ['nullable', 'string', 'max:100'],
            'flag'        => ['nullable', 'string', 'max:10'],
            'dir'         => ['required', 'in:ltr,rtl'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_active'   => ['boolean'],
            'is_default'  => ['boolean'],
        ];
    }
}
