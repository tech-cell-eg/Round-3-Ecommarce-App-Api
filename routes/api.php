<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;


// authenticated end points
Route::controller(UserController::class)->prefix('users')->group(function(){
    Route::get('display','index');
    Route::post('/register','store');
    Route::post('/login','login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

// Products end points
Route::get('products', [ProductController::class, 'index'])->middleware('auth:sanctum');
Route::get('products/{id}', [ProductController::class, 'show']);

// Cart end points
Route::get('cart', [CartController::class, 'index']);
Route::post('cart', [CartController::class, 'store']);


