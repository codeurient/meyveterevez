<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ==================== AUTH ====================

Route::prefix('auth')->group(function () {
    Route::post('/login',    [LoginController::class,    'store'])->name('api.login')->middleware('throttle:5,1');
    Route::post('/register', [RegisterController::class, 'store'])->name('api.register')->middleware('throttle:10,1');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [LoginController::class, 'destroy'])->name('api.logout');
        Route::get('/user', fn (Request $request) => $request->user())->name('api.user');
    });
});
