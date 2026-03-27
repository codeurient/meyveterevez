<?php

declare(strict_types=1);

namespace App\Actions\Admin\Category;

use App\DTOs\Admin\CategoryDTO;
use App\Models\Category;

final class UpdateCategoryAction
{
    public function execute(Category $category, CategoryDTO $dto): Category
    {
        $level = $dto->parentId ? 2 : 1;
        $path  = $dto->parentId ? (string) $dto->parentId : null;

        $category->update([
            'name'              => $dto->name,
            'name_translations' => $dto->nameTranslations,
            'slug'        => $dto->slug,
            'icon'        => $dto->icon,
            'color'       => $dto->color,
            'description' => $dto->description,
            'parent_id'   => $dto->parentId,
            'level'       => $level,
            'path'        => $path,
            'sort_order'  => $dto->sortOrder,
            'is_active'   => $dto->isActive,
        ]);

        return $category->fresh();
    }
}
