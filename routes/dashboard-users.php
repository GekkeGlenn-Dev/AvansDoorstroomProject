<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('gebruikers')->name('user.')->group(function () {
    Route::get('/', [
        UserController::class,
        'index'
    ])->name('index');

//    Route::post('/', [
//        UserController::class,
//        'store'
//    ])->name('store');
});


Route::prefix('user/{user}')->name('user.')->group(function () {
    Route::get('bewerken', [
        UserController::class,
        'edit'
    ])->name('edit');

    Route::put('opslaan', [
        UserController::class,
        'update'
    ])->name('update');
});
