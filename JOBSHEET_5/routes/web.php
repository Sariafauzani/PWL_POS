<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\penjualanController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/user', [UserController::class, 'index']);

Route::get('/user/tambah', [UserController::class, 'tambah']);
Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);

// Jobsheet 5
Route::get('/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);            // menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']);        // menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']);     // menampilkan halaman form tambah user
    Route::post('/', [UserController::class, 'store']);           // menyimpan data user baru
    Route::get('/{id}', [UserController::class, 'show']);         // menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']);    // menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']);      // menyimpan perubahan data user
    Route::delete('/{id}', [UserController::class, 'destroy']);   // menghapus data user
});

Route::group(['prefix'=>'level'],function(){
    Route::get('/',[LevelController::class,'index'])->name('level.index');
    Route::post('/list',[LevelController::class,'list'])->name('level.list');
    Route::get('/create',[LevelController::class,'create'])->name('level.create');
    Route::get('/{id}',[LevelController::class,'show']);
    Route::post('/',[LevelController::class,'store']);
    Route::get('/{id}/edit', [LevelController::class,'edit'])->name('level.edit');
    Route::put('/{id}', [LevelController::class,'update']);
    Route::delete('/{id}',[LevelController::class,'destroy']);
});

Route::group(['prefix'=>'kategori'],function(){
    Route::get('/',[kategoriController::class,'index'])->name('kategori.index');
    Route::post('/list',[kategoriController::class,'list'])->name('kategori.list');
    Route::get('/create',[kategoriController::class,'create'])->name('kategori.create');
    Route::post('/',[kategoriController::class,'store']);
    Route::get('/{id}/edit', [kategoriController::class,'edit'])->name('kategori.edit');
    Route::put('/{id}', [kategoriController::class,'update']);
    Route::delete('/{id}',[kategoriController::class,'destroy']);
});

Route::group(['prefix'=>'barang'],function(){
    Route::get('/',[BarangController::class,'index']);
    Route::post('/list',[BarangController::class,'list']);
    Route::get('/create',[BarangController::class,'create']);
    Route::post('/',[BarangController::class,'store']);
    Route::get('/{id}/edit', [BarangController::class,'edit']);
    Route::put('/{id}', [BarangController::class,'update']);
    Route::delete('/{id}',[BarangController::class,'destroy']);
});

Route::group(['prefix' => 'supplier'], function(){
    Route::get('/', [SupplierController::class, 'index']);
    Route::post('/list', [SupplierController::class, 'list']);
    Route::get('/create', [SupplierController::class, 'create']);
    Route::post('/', [SupplierController::class, 'store']);
    Route::get('/{id}', [SupplierController::class, 'show']);
    Route::get('/{id}/edit', [SupplierController::class, 'edit']);
    Route::put('/{id}', [SupplierController::class, 'update']);
    Route::delete('/{id}', [SupplierController::class, 'destroy']);
});

Route::group(['prefix'=>'stok'],function(){
    Route::get('/',[StokController::class,'index']);
    Route::post('/list',[StokController::class,'list']);
    Route::get('/create',[StokController::class,'create']);
    Route::post('/',[StokController::class,'store']);
    Route::get('/{id}',[StokController::class,'show']);
    Route::get('/{id}/edit', [StokController::class,'edit']);
    Route::put('/{id}', [StokController::class,'update']);
    Route::delete('/{id}',[StokController::class,'destroy']);
});

Route::group(['prefix'=>'penjualan'],function(){
    Route::get('/',[penjualanController::class,'index']);
    Route::post('/list',[penjualanController::class,'list']);
    Route::post('/',[penjualanController::class,'store']);
    Route::get('/{id}',[penjualanController::class,'show']);
    Route::delete('/{id}',[penjualanController::class,'destroy']);
    Route::get('/{id}/edit', [penjualanController::class,'edit']);
});