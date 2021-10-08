<?php


use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


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
])->name('product.create');

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
