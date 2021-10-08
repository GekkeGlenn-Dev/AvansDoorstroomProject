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
auth()->loginUsingId(1);
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

include_once('dashboard.php');

