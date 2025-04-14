<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;



// authenticated end points
Route::controller(UserController::class)->prefix('auth')->group(function () {
    Route::post('/register', 'store');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

Route::get('/users', 'index');

// Products end points
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'show']);

// Cart end points
Route::get('cart', [CartController::class, 'index'])->middleware('auth:sanctum');
Route::post('cart', [CartController::class, 'store'])->middleware('auth:sanctum');

/// orders endpoints
Route::controller(OrderController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('orders', 'index');
    Route::get('orders/{id}', 'show');
});







