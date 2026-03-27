<?php

declare(strict_types=1);

namespace App\Actions\Admin\Product;

use App\DTOs\Admin\ProductDTO;
use App\Models\Product;
use App\Models\StoreProfile;
use Illuminate\Support\Facades\DB;

final class CreateProductAction
{
    public function execute(ProductDTO $dto): Product
    {
        return DB::transaction(function () use ($dto): Product {
            $store = StoreProfile::findOrFail($dto->storeProfileId);

            return Product::create([
                'name'                    => $dto->name,
                'name_translations'       => $dto->nameTranslations,
                'slug'                    => $dto->slug,
                'description'             => $dto->description,
                'description_translations' => $dto->descriptionTranslations,
                'category_id'      => $dto->categoryId,
                'store_profile_id' => $dto->storeProfileId,
                'user_id'          => $store->user_id,
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
        });
    }
}
