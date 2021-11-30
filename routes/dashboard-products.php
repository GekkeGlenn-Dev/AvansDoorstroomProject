<?php

use App\Http\Controllers\ProductCategoryController;
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

    Route::delete('verwijder', [
        ProductController::class,
        'destroy'
    ])->name('destroy');

    Route::put('opslaan', [
        ProductController::class,
        'update'
    ])->name('update');
});

// Categories
Route::prefix('product/categorieën')->name('product.category.')->group(function () {
    Route::get('/', [
        ProductCategoryController::class,
        'index'
    ])->name('index');

    Route::post('/', [
        ProductCategoryController::class,
        'store'
    ])->name('store');
});

Route::prefix('producten/categorie/{productCategory:slug}')->name('product.category.')->group(function () {
    Route::delete('verwijder', [
        ProductCategoryController::class,
        'destroy'
    ])->name('destroy');

    Route::put('opslaan', [
        ProductCategoryController::class,
        'update'
    ])->name('update');
});
