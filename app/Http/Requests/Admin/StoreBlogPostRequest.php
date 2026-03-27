<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'title_translations'        => ['required', 'array'],
            'title_translations.az'     => ['required', 'string', 'max:300'],
            'title_translations.en'     => ['nullable', 'string', 'max:300'],
            'slug'                      => ['nullable', 'string', 'max:320', 'unique:blog_posts,slug'],
            'excerpt_translations'      => ['nullable', 'array'],
            'excerpt_translations.az'   => ['nullable', 'string', 'max:500'],
            'excerpt_translations.en'   => ['nullable', 'string', 'max:500'],
            'content_translations'      => ['required', 'array'],
            'content_translations.az'   => ['required', 'string'],
            'content_translations.en'   => ['nullable', 'string'],
            'is_published'              => ['boolean'],
            'published_at'              => ['nullable', 'date'],
        ];
    }
}
