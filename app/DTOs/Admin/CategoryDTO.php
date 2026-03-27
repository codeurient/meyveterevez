<?php

declare(strict_types=1);

namespace App\DTOs\Admin;

use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use Illuminate\Support\Str;

final class CategoryDTO
{
    public function __construct(
        public readonly array   $nameTranslations,
        public readonly string  $name,
        public readonly string  $slug,
        public readonly ?string $icon,
        public readonly ?string $color,
        public readonly ?string $description,
        public readonly ?int    $parentId,
        public readonly int     $sortOrder,
        public readonly bool    $isActive,
    ) {}

    public static function fromRequest(StoreCategoryRequest|UpdateCategoryRequest $request): self
    {
        $translations = array_filter(
            $request->validated('name_translations', []),
            fn ($v) => filled($v)
        );

        $name = $translations['az'] ?? $translations['en'] ?? '';

        $slug = filled($request->validated('slug'))
            ? $request->validated('slug')
            : Str::slug($name);

        return new self(
            nameTranslations: $translations,
            name:             $name,
            slug:             $slug,
            icon:             $request->validated('icon'),
            color:            $request->validated('color'),
            description:      $request->validated('description'),
            parentId:         $request->validated('parent_id') ? (int) $request->validated('parent_id') : null,
            sortOrder:        (int) $request->validated('sort_order', 0),
            isActive:         (bool) $request->validated('is_active', true),
        );
    }
}
