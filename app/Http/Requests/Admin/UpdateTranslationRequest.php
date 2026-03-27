<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTranslationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'key'       => ['required', 'string', 'max:255'],
            'locale'    => ['required', 'string', 'exists:locales,code'],
            'group'     => ['required', 'string', 'max:50'],
            'value'     => ['required', 'string'],
            'is_active' => ['boolean'],
        ];
    }
}
