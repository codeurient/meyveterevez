<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'name'                    => ['required', 'string', 'max:150'],
            'name_translations'       => ['nullable', 'array'],
            'name_translations.*'     => ['nullable', 'string', 'max:150'],
            'type'                    => ['required', 'in:country,state,city'],
            'parent_id'               => ['nullable', 'integer', 'exists:locations,id'],
            'code'                    => ['nullable', 'string', 'max:10'],
            'latitude'                => ['nullable', 'numeric', 'between:-90,90'],
            'longitude'               => ['nullable', 'numeric', 'between:-180,180'],
            'is_active'               => ['boolean'],
        ];
    }
}
