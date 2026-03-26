<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::active()->with(['primaryImage', 'store', 'category'])->inStock();

        $this->applyFilters($query, $request);

        $products = $query->paginate(24)->withQueryString();
        $categories = Category::active()->root()->get();

        return view('pages.products.index', compact('products', 'categories'));
    }

    public function show(string $slug): View
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'active')
            ->with(['images', 'primaryImage', 'store', 'category', 'reviews.user'])
            ->withCount('reviews')
            ->firstOrFail();

        // Increment view count (non-critical, fire and forget)
        $product->increment('views_count');

        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['primaryImage', 'store'])
            ->inStock()
            ->take(6)
            ->get();

        // Other stores selling same category
        $otherSellers = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['store', 'primaryImage'])
            ->inStock()
            ->orderBy('price')
            ->take(5)
            ->get();

        return view('pages.products.show', compact('product', 'relatedProducts', 'otherSellers'));
    }

    public function search(Request $request): View
    {
        $query = Product::active()->with(['primaryImage', 'store', 'category'])->inStock();

        if ($q = $request->get('q')) {
            $query->where(function ($q2) use ($q) {
                $q2->where('name', 'like', "%{$q}%")
                   ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $this->applyFilters($query, $request);

        $products = $query->paginate(24)->withQueryString();
        $categories = Category::active()->root()->get();

        return view('pages.products.search', compact('products', 'categories'));
    }

    private function applyFilters(\Illuminate\Database\Eloquent\Builder $query, Request $request): void
    {
        // Category filter
        if ($categorySlug = $request->get('category')) {
            $catId = \App\Models\Category::where('slug', $categorySlug)->value('id');
            if ($catId) {
                $query->where('category_id', $catId);
            }
        }

        // Organic filter
        if ($request->boolean('organic')) {
            $query->organic();
        }

        // Price range
        if ($min = $request->get('price_min')) {
            $query->where('price', '>=', (float) $min);
        }
        if ($max = $request->get('price_max')) {
            $query->where('price', '<=', (float) $max);
        }

        // Rating filter
        if ($rating = $request->get('rating')) {
            $query->where('rating_avg', '>=', (float) $rating);
        }

        // Sort
        match ($request->get('sort', 'default')) {
            'price-asc'  => $query->orderBy('price'),
            'price-desc' => $query->orderByDesc('price'),
            'rating'     => $query->orderByDesc('rating_avg'),
            'discount'   => $query->orderByDesc('discount_percent'),
            'newest'     => $query->latest(),
            default      => $query->orderByDesc('is_featured')->orderByDesc('sale_count'),
        };
    }
}
