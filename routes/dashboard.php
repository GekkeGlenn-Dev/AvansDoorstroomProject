<?php

use App\Http\Controllers\DashboardController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [
        DashboardController::class,
        'dashboard'
    ])->name('home');

    /** Admin routes */
    Route::middleware(IsAdmin::class)->group(function () {
        include_once('dashboard-products.php');
        include_once('dashboard-orders.php');
        include_once('dashboard-users.php');
    });
});
