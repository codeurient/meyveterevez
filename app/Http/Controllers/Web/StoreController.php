<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\StoreProfile;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function index(): View
    {
        $stores = StoreProfile::active()
            ->orderByDesc('rating_avg')
            ->paginate(16);

        return view('pages.stores.index', compact('stores'));
    }

    public function show(string $slug, Request $request): View
    {
        $store = StoreProfile::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $query = Product::active()
            ->where('store_profile_id', $store->id)
            ->with(['primaryImage', 'category'])
            ->inStock();

        match ($request->get('sort', 'default')) {
            'price-asc'  => $query->orderBy('price'),
            'price-desc' => $query->orderByDesc('price'),
            'rating'     => $query->orderByDesc('rating_avg'),
            default      => $query->orderByDesc('sale_count'),
        };

        $products = $query->paginate(20)->withQueryString();

        return view('pages.stores.show', compact('store', 'products'));
    }
}
