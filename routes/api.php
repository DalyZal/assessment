<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::resources([
    'products' => ProductController::class,
    'categories' => CategoryController::class,
]);
Route::get('category/{categoryId}/get-products', [ProductController::class, 'getPorductsByCategory']);
Route::get('products/{productId}/set-category/{categoryId}', [ProductController::class, 'setCategory']);

Route::fallback(function(){
    return response()->json(['message' => 'Humans have been migrated from here a long time ago. Please follow their path!'], 404);
});
