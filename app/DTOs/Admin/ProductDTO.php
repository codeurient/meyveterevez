<?php

declare(strict_types=1);

namespace App\DTOs\Admin;

use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use Illuminate\Support\Str;

final class ProductDTO
{
    public function __construct(
        public readonly array   $nameTranslations,
        public readonly string  $name,
        public readonly string  $slug,
        public readonly array   $descriptionTranslations,
        public readonly ?string $description,
        public readonly int     $categoryId,
        public readonly int     $storeProfileId,
        public readonly float   $price,
        public readonly ?float  $originalPrice,
        public readonly int     $discountPercent,
        public readonly string  $unit,
        public readonly int     $stockQuantity,
        public readonly string  $status,
        public readonly bool    $isOrganic,
        public readonly bool    $isFreshToday,
        public readonly bool    $isFeatured,
        public readonly bool    $isTopSeller,
        public readonly bool    $inStock,
    ) {}

    public static function fromRequest(StoreProductRequest|UpdateProductRequest $request): self
    {
        $nameTranslations = (array) $request->validated('name_translations', []);
        $name             = $nameTranslations['az'] ?? $nameTranslations['en'] ?? '';

        $slug = filled($request->validated('slug'))
            ? $request->validated('slug')
            : Str::slug($name);

        $descriptionTranslations = (array) $request->validated('description_translations', []);
        $description             = $descriptionTranslations['az'] ?? $descriptionTranslations['en'] ?? null;

        return new self(
            nameTranslations:        $nameTranslations,
            name:                    $name,
            slug:                    $slug,
            descriptionTranslations: $descriptionTranslations,
            description:             filled($description) ? $description : null,
            categoryId:              (int) $request->validated('category_id'),
            storeProfileId:          (int) $request->validated('store_profile_id'),
            price:                   (float) $request->validated('price'),
            originalPrice:           $request->validated('original_price') !== null
                                         ? (float) $request->validated('original_price')
                                         : null,
            discountPercent:         (int) $request->validated('discount_percent', 0),
            unit:                    $request->validated('unit'),
            stockQuantity:           (int) $request->validated('stock_quantity', 0),
            status:                  $request->validated('status'),
            isOrganic:               (bool) $request->validated('is_organic', false),
            isFreshToday:            (bool) $request->validated('is_fresh_today', false),
            isFeatured:              (bool) $request->validated('is_featured', false),
            isTopSeller:             (bool) $request->validated('is_top_seller', false),
            inStock:                 (bool) $request->validated('in_stock', true),
        );
    }
}
