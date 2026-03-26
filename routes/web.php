<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LocationController as AdminLocationController;
use App\Http\Controllers\Admin\PhoneCodeController as AdminPhoneCodeController;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\Auth\RegisterController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\StoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==================== PUBLIC ====================

Route::get('/', HomeController::class)->name('home');

// Products
Route::get('/products',        [ProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Categories
Route::get('/categories',        [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Stores
Route::get('/stores',        [StoreController::class, 'index'])->name('stores.index');
Route::get('/stores/create', fn () => view('pages.home.index'))->name('stores.create');
Route::get('/stores/{slug}', [StoreController::class, 'show'])->name('stores.show');

// Map
Route::get('/map', fn () => view('pages.home.index'))->name('map');

// Favorites
Route::get('/favorites', fn () => view('pages.home.index'))->name('favorites.index');

// Orders
Route::get('/orders',    fn () => view('pages.home.index'))->name('orders.index');
Route::get('/checkout',  fn () => view('pages.home.index'))->name('checkout');

// Profile
Route::get('/profile',   fn () => view('pages.home.index'))->name('profile');

// ==================== AUTH ====================

Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class,    'show'])->name('login');
    Route::post('/login',   [LoginController::class,    'store'])->middleware('throttle:5,1');
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register',[RegisterController::class, 'store'])->middleware('throttle:10,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});

// ==================== ADMIN ====================

Route::prefix(config('admin.path'))
    ->middleware(['web', 'admin', 'throttle:60,1'])
    ->name('admin.')
    ->group(function () {
        Route::get('/',             AdminDashboardController::class)->name('dashboard');
        Route::resource('locations', AdminLocationController::class);
        Route::resource('phone-codes', AdminPhoneCodeController::class)->parameters([
            'phone-codes' => 'phoneCode',
        ]);
    });
