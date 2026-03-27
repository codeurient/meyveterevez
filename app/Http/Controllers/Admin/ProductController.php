<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Product\CreateProductAction;
use App\Actions\Admin\Product\DeleteProductAction;
use App\Actions\Admin\Product\UpdateProductAction;
use App\DTOs\Admin\ProductDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\StoreProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with(['category', 'storeProfile', 'primaryImage'])
            ->orderByDesc('created_at');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(fn ($q) => $q->where('name', 'like', "%{$search}%")
                                       ->orWhere('slug', 'like', "%{$search}%"));
        }

        $products   = $query->paginate(25)->withQueryString();
        $categories = Category::orderBy('level')->orderBy('sort_order')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('level')->orderBy('sort_order')->get();
        $stores     = StoreProfile::where('is_active', true)->orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'stores'));
    }

    public function store(StoreProductRequest $request, CreateProductAction $action): RedirectResponse
    {
        $action->execute(ProductDTO::fromRequest($request));

        return redirect()->route('admin.products.index')
            ->with('success', __t('admin.product_created'));
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('level')->orderBy('sort_order')->get();
        $stores     = StoreProfile::where('is_active', true)->orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'stores'));
    }

    public function update(UpdateProductRequest $request, Product $product, UpdateProductAction $action): RedirectResponse
    {
        $action->execute($product, ProductDTO::fromRequest($request));

        return redirect()->route('admin.products.index')
            ->with('success', __t('admin.product_updated'));
    }

    public function destroy(Product $product, DeleteProductAction $action): RedirectResponse
    {
        $action->execute($product);

        return redirect()->route('admin.products.index')
            ->with('success', __t('admin.product_deleted'));
    }
}
