<?php

use App\Http\Controllers\BasketController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [
        DashboardController::class,
        'dashboard'
    ])->name('home');

    Route::get('bestellingen' , [
        OrderController::class,
        'showAll'
    ])->name('me.orders');

    Route::get('bestellingen/{order:number}' , [
        OrderController::class,
        'show'
    ])->name('me.orders.details');
});

/** Admin routes */
Route::middleware(['auth:sanctum', 'verified', IsAdmin::class])
    ->prefix('dashboard/admin')->name('dashboard.')->group(function () {

        Route::get('/', [
            DashboardController::class,
            'admin'
        ])->name('admin');

        include_once('dashboard-products.php');
        include_once('dashboard-orders.php');
        include_once('dashboard-users.php');
    });
