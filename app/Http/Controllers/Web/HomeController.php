<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Services\StoreLocationService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(Request $request, StoreLocationService $locationService): View
    {
        $sliders = Slider::active()->main()->get();

        $categories = Category::active()->root()->with('children')->get();

        $featuredProducts = Product::featured()
            ->with(['primaryImage', 'store'])
            ->inStock()
            ->orderByDesc('sale_count')
            ->take(10)
            ->get();

        $topSellerProducts = Product::topSellers()
            ->with(['primaryImage', 'store'])
            ->inStock()
            ->orderByDesc('sale_count')
            ->take(10)
            ->get();

        $newArrivals = Product::active()
            ->with(['primaryImage', 'store'])
            ->inStock()
            ->latest()
            ->take(10)
            ->get();

        $discountedProducts = Product::discounted()
            ->with(['primaryImage', 'store'])
            ->inStock()
            ->orderByDesc('discount_percent')
            ->take(8)
            ->get();

        // Location-aware store discovery
        $lat = session('user_lat') !== null ? (float) session('user_lat') : null;
        $lng = session('user_lng') !== null ? (float) session('user_lng') : null;

        $storeResult    = $locationService->resolve($request->user(), $lat, $lng);
        $featuredStores = $storeResult['stores'];
        $storesTitle    = $storeResult['title'];
        $storesDesc     = $storeResult['desc'];
        $storesWarning  = $storeResult['warning'];

        return view('pages.home.index', compact(
            'sliders',
            'categories',
            'featuredProducts',
            'topSellerProducts',
            'newArrivals',
            'discountedProducts',
            'featuredStores',
            'storesTitle',
            'storesDesc',
            'storesWarning',
        ));
    }
}
