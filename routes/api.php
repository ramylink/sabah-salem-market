<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\CartApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\AuthApiController;

Route::prefix('v1')->group(function () {
    // Auth
    Route::post('/register', [AuthApiController::class, 'register']);
    Route::post('/login', [AuthApiController::class, 'login']);

    // Products (public)
    Route::get('/products', [ProductApiController::class, 'index']);
    Route::get('/products/featured', [ProductApiController::class, 'featured']);
    Route::get('/products/new', [ProductApiController::class, 'newArrivals']);
    Route::get('/products/sale', [ProductApiController::class, 'onSale']);
    Route::get('/products/search', [ProductApiController::class, 'search']);
    Route::get('/products/{slug}', [ProductApiController::class, 'show']);
    Route::get('/categories', [ProductApiController::class, 'categories']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [AuthApiController::class, 'user']);
        Route::post('/logout', [AuthApiController::class, 'logout']);

        // Cart
        Route::get('/cart', [CartApiController::class, 'index']);
        Route::post('/cart', [CartApiController::class, 'add']);
        Route::put('/cart/{itemId}', [CartApiController::class, 'update']);
        Route::delete('/cart/{itemId}', [CartApiController::class, 'remove']);
        Route::delete('/cart', [CartApiController::class, 'clear']);

        // Orders
        Route::get('/orders', [OrderApiController::class, 'index']);
        Route::get('/orders/{orderNumber}', [OrderApiController::class, 'show']);
        Route::post('/orders', [OrderApiController::class, 'store']);
        Route::post('/orders/{orderNumber}/cancel', [OrderApiController::class, 'cancel']);
        Route::post('/orders/{orderNumber}/reorder', [OrderApiController::class, 'reorder']);
    });
});
