<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
Route::get('shop', [PageController::class, 'shop'])->name('shop');
Route::get('shop/product/{product:slug}', [ProductController::class, 'show'])->name('shop.product.show');
//Route::get('/', function () {
//    return Inertia::render('Dashboard/Dashboard'/*, [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]*/);
//});

//Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//    return Inertia::render('Dashboard');
//})->name('dashboard');

Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [
        DashboardController::class,
        'dashboard'
    ])->name('home');

    // Products
    Route::prefix('producten')->name('product.')->group(function () {
        Route::get('/', [
            ProductController::class,
            'index'
        ])->name('index');

        Route::post('/', [
            ProductController::class,
            'store'
        ])->name('store');
    });

    Route::get('product/toevoegen', [
        ProductController::class,
        'create'
    ])->name('create');

    Route::prefix('product/{product:slug}')->name('product.')->group(function () {
        Route::get('bewerken', [
            ProductController::class,
            'edit'
        ])->name('edit');

        Route::put('opslaan', [
            ProductController::class,
            'update'
        ])->name('update');
    });
});
