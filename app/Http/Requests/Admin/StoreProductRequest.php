<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'name_translations'        => ['required', 'array'],
            'name_translations.az'     => ['required', 'string', 'max:200'],
            'name_translations.en'     => ['nullable', 'string', 'max:200'],
            'slug'                     => ['nullable', 'string', 'max:220', 'unique:products,slug'],
            'description_translations'     => ['nullable', 'array'],
            'description_translations.az'  => ['nullable', 'string'],
            'description_translations.en'  => ['nullable', 'string'],
            'category_id'              => ['required', 'integer', 'exists:categories,id'],
            'store_profile_id'         => ['required', 'integer', 'exists:store_profiles,id'],
            'price'                    => ['required', 'numeric', 'min:0'],
            'original_price'           => ['nullable', 'numeric', 'min:0'],
            'discount_percent'         => ['nullable', 'integer', 'min:0', 'max:100'],
            'unit'                     => ['required', 'in:kg,piece,bunch,g'],
            'stock_quantity'           => ['nullable', 'integer', 'min:0'],
            'status'                   => ['required', 'in:active,draft,inactive'],
            'is_organic'               => ['boolean'],
            'is_fresh_today'           => ['boolean'],
            'is_featured'              => ['boolean'],
            'is_top_seller'            => ['boolean'],
            'in_stock'                 => ['boolean'],
        ];
    }
}
