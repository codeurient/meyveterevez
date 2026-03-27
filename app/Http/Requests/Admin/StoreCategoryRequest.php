<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'name_translations'     => ['nullable', 'array'],
            'name_translations.az'  => ['required', 'string', 'max:100'],
            'name_translations.en'  => ['nullable', 'string', 'max:100'],
            'slug'                  => ['nullable', 'string', 'max:150', 'unique:categories,slug'],
            'icon'                  => ['nullable', 'string', 'max:10'],
            'color'                 => ['nullable', 'string', 'max:20'],
            'description'           => ['nullable', 'string', 'max:500'],
            'parent_id'             => ['nullable', 'integer', 'exists:categories,id'],
            'sort_order'            => ['nullable', 'integer', 'min:0'],
            'is_active'             => ['boolean'],
        ];
    }
}
