<?php

declare(strict_types=1);

namespace App\Actions\Admin\Product;

use App\DTOs\Admin\ProductDTO;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

final class UpdateProductAction
{
    public function execute(Product $product, ProductDTO $dto): Product
    {
        return DB::transaction(function () use ($product, $dto): Product {
            $product->update([
                'name'                    => $dto->name,
                'name_translations'       => $dto->nameTranslations,
                'slug'                    => $dto->slug,
                'description'             => $dto->description,
                'description_translations' => $dto->descriptionTranslations,
                'category_id'      => $dto->categoryId,
                'store_profile_id' => $dto->storeProfileId,
                'price'            => $dto->price,
                'original_price'   => $dto->originalPrice,
                'discount_percent' => $dto->discountPercent,
                'unit'             => $dto->unit,
                'stock_quantity'   => $dto->stockQuantity,
                'status'           => $dto->status,
                'is_organic'       => $dto->isOrganic,
                'is_fresh_today'   => $dto->isFreshToday,
                'is_featured'      => $dto->isFeatured,
                'is_top_seller'    => $dto->isTopSeller,
                'in_stock'         => $dto->inStock,
            ]);

            return $product->fresh();
        });
    }
}
