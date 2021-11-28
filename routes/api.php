<?php

use App\Http\Controllers\ApiControllers\BasketApiController;
use App\Http\Controllers\ApiControllers\ProductApiController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\HostAllow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(HostAllow::class)->prefix('v1')->name('api.v1.')->group(function () {
    Route::get('products', [ProductApiController::class, 'index'])->name('product.index');

    Route::get('basket', [BasketApiController::class, 'index'])->name('basket.index');
});

