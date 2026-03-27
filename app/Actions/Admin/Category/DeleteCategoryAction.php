<?php

declare(strict_types=1);

namespace App\Actions\Admin\Category;

use App\Models\Category;
use Illuminate\Validation\ValidationException;

final class DeleteCategoryAction
{
    public function execute(Category $category): void
    {
        if ($category->children()->exists()) {
            throw ValidationException::withMessages([
                'category' => [__t('admin.category_delete_has_children_error')],
            ]);
        }

        $category->delete();
    }
}
