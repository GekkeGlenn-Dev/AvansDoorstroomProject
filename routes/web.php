<?php

use App\Http\Controllers\BasketController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\ProductsOnBasketCheck;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//auth()->loginUsingId(2);
Route::get('/', [PageController::class, 'shop'])->name('shop');
Route::get('product/{product:slug}', [ProductController::class, 'show'])->name('shop.product.show');

Route::get('winkelmandje/product/toevoegen/{product:slug}', [BasketController::class, 'addProduct'])->name('shop.product.add');
Route::get('winkelmandje/product/verwijder/{product:slug}', [BasketController::class, 'removeProduct'])->name('shop.product.remove');

Route::get('winkelmandje', [BasketController::class, 'index'])->name('basket');
Route::middleware(ProductsOnBasketCheck::class)->get('winkelmandje/uitchecken', [BasketController::class, 'checkoutDetails'])->name('basket.checkout');
Route::middleware(ProductsOnBasketCheck::class)->post('winkelmandje/uitchecken', [BasketController::class, 'processCheckout'])->name('basket.checkout.process');
Route::get('winkelmandje/{order:number}/betaald', [BasketController::class, 'checkoutOrderDetails'])->name('basket.checkout.finish');

include_once('dashboard.php');

