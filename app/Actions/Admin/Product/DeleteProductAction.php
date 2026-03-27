<?php

declare(strict_types=1);

namespace App\Actions\Admin\Product;

use App\Models\Product;

final class DeleteProductAction
{
    public function execute(Product $product): void
    {
        $product->delete();
    }
}
