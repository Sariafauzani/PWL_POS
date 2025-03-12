<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Halaman Home
Route::get('/home', [HomeController::class, 'index'])->name('index');

// Halaman Product dengan Prefix Category
Route::prefix('category')->group(function () {
    Route::get('/food-beverage', [ProdukController::class, 'foodBeverage'])->name('foodBeverage');
    Route::get('/beauty-health', [ProdukController::class, 'beautyHealth'])->name('beautyHealth');
    Route::get('/home-care', [ProdukController::class, 'homeCare'])->name('homeCare');
    Route::get('/baby-kid', [ProdukController::class, 'babyKid'])->name('babyKid');
});

// Halaman User dengan Id dan Name
Route::get('/user/{id}/name/{name}', [UserController::class, 'showProfile'])->name('user.profile');

// Halaman Penjualan (POS)
Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');