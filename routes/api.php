<?php

use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\ProductApiController;
use Illuminate\Support\Facades\Route;

Route::get('/health', fn () => response()->json([
    'status' => 'ok',
    'app' => config('app.name'),
    'timestamp' => now()->toISOString(),
]));

Route::get('/categories', [CategoryApiController::class, 'index']);
Route::get('/products', [ProductApiController::class, 'index']);
Route::get('/products/{product}', [ProductApiController::class, 'show']);
Route::post('/orders', [OrderApiController::class, 'store']);
Route::get('/orders/{order_number}', [OrderApiController::class, 'show']);
