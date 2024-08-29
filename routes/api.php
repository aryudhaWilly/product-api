<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth.token')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);  // List products
    Route::post('/products', [ProductController::class, 'store']);  // Create product
    Route::get('/products/{id}', [ProductController::class, 'show']);  // Get a single product
    Route::put('/products/{id}', [ProductController::class, 'update']);  // Update product
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);  // Delete product
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
