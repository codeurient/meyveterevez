<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::active()->root()->with('children')->get();

        return view('pages.categories.index', compact('categories'));
    }

    public function show(string $slug, Request $request): View
    {
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();

        // Include sub-category IDs so products from children also appear
        $categoryIds = collect([$category->id]);
        if ($category->children()->exists()) {
            $categoryIds = $categoryIds->merge($category->children()->pluck('id'));
        }

        $query = Product::active()
            ->whereIn('category_id', $categoryIds)
            ->with(['primaryImage', 'store'])
            ->inStock();

        // Apply sorting
        match ($request->get('sort', 'default')) {
            'price-asc'  => $query->orderBy('price'),
            'price-desc' => $query->orderByDesc('price'),
            'rating'     => $query->orderByDesc('rating_avg'),
            'discount'   => $query->orderByDesc('discount_percent'),
            default      => $query->orderByDesc('is_featured')->orderByDesc('sale_count'),
        };

        $products = $query->paginate(24)->withQueryString();

        return view('pages.categories.show', compact('category', 'products'));
    }
}
