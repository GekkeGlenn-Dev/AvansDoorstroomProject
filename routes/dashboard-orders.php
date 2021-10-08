<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('bestellingen')->name('order.')->group(function () {
    Route::get('/', [
        OrderController::class,
        'index'
    ])->name('index');

    Route::post('/', [
        OrderController::class,
        'store'
    ])->name('store');

    Route::post('/toevoegen', [
        OrderController::class,
        'create'
    ])->name('create');
});

Route::prefix('bestelling/{order:number}')->name('order.')->group(function () {
    Route::get('bewerken', [
        OrderController::class,
        'edit'
    ])->name('edit');

    Route::post('/', [
        OrderController::class,
        'update'
    ])->name('update');
});
