<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'postregister']);

// Jobsheet 7
Route::pattern('id', '[0-9]+'); // artinya ketika ada paramete {id}, maka harus berupa angka

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware(['auth'])->group(function () { // artinya semua route di dalam group ini harus login dulu
    // masukan semua route yang perlu authentikasi di sini

    // Jobsheet 5
    Route::get('/', [WelcomeController::class, 'index']);

    Route::get('/profile', [UserController::class, 'profile']);
    Route::post('/user/update-photo', [UserController::class, 'updatePhoto']);

    // artinya semua route di dalam group ini harus punya role ADM (Administrator), MNG (Manager), dan STF (Staff)
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [UserController::class, 'index']);                          // menampilkan halaman awal user
            Route::post('/list', [UserController::class, 'list']);                      // menampilkan data user dalam bentuk json untuk datatables
            Route::get('/create', [UserController::class, 'create']);                   // menampilkan halaman form tambah user
            Route::post('/', [UserController::class, 'store']);                         // menyimpan data user baru
            Route::get('/create_ajax', [UserController::class, 'create_ajax']);         // menampilkan halaman form tambah user ajax
            Route::post('/ajax', [UserController::class, 'store_ajax']);                // menyimpan data user baru ajax
            Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']);        // menampilkan detail user
            Route::get('/{id}', [UserController::class, 'show']);                       // menampilkan detail user
            Route::get('/{id}/edit', [UserController::class, 'edit']);                  // menampilkan halaman form edit user
            Route::put('/{id}', [UserController::class, 'update']);                     // menyimpan perubahan data user
            Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);        // menampilkan halaman form edit user Ajax
            Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);    // menyimpan perubahan data user Ajax
            Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);   // untuk tampilkan form confirm  delete user Ajax
            Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // untuk menghapus data user Ajax
            Route::delete('/{id}', [UserController::class, 'destroy']);                 // menghapus data user
            Route::get('/import', [UserController::class, 'import']);                   // ajax form upload excel
            Route::post('/import_ajax', [UserController::class, 'import_ajax']);        // ajax import excel
            Route::get('/export_excel', [UserController::class, 'export_excel']); // export excel 
            Route::get('/export_pdf', [UserController::class, 'export_pdf']);     // export pdf               
        });
    });

    // artinya semua route di dalam group ini harus punya role ADM (Administrator)
    Route::group(['prefix' => 'level'], function () {
        Route::middleware(['authorize:ADM'])->group(function () {
            Route::get('/', [LevelController::class, 'index'])->name('level.index');
            Route::post('/list', [LevelController::class, 'list'])->name('level.list');
            Route::get('/create', [LevelController::class, 'create'])->name('level.create');
            Route::get('/create_ajax', [LevelController::class, 'create_ajax']);            // menampilkan halaman form tambah level ajax
            Route::get('/{id}', [LevelController::class, 'show']);
            Route::get('/{id}/show_ajax', [LevelController::class, 'show_ajax']);           // menampilkan detail level
            Route::post('/', [LevelController::class, 'store']);
            Route::post('/ajax', [LevelController::class, 'store_ajax']);                   // menyimpan data level baru ajax
            Route::get('/{id}/edit', [LevelController::class, 'edit'])->name('level.edit');
            Route::put('/{id}', [LevelController::class, 'update']);
            Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);           // menampilkan halaman form edit Level Ajax
            Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);       // menyimpan perubahan data Level Ajax
            Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);      // untuk tampilkan form confirm  delete Level Ajax
            Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);    // untuk menghapus data Level Ajax
            Route::delete('/{id}', [LevelController::class, 'destroy']);
            Route::get('/import', [LevelController::class, 'import']);
            Route::post('/import_ajax', [LevelController::class, 'import_ajax']);
            Route::get('/export_excel', [LevelController::class, 'export_excel']); // export excel
            Route::get('/export_pdf', [LevelController::class, 'export_pdf']);     // export pdf
        });
    });

    // artinya semua route di dalam group ini harus punya role ADM (Administrator), MNG (Manager), dan STF (Staff)
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::group(['prefix' => 'kategori'], function () {
            Route::get('/', [KategoriController::class, 'index'])->name('kategori.index');
            Route::post('/list', [KategoriController::class, 'list'])->name('kategori.list');
            Route::get('/create', [KategoriController::class, 'create'])->name('kategori.create');
            Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);                // menampilkan halaman form tambah kategori ajax
            Route::post('/', [KategoriController::class, 'store']);
            Route::post('/ajax', [KategoriController::class, 'store_ajax']);                       // menyimpan data kategori baru ajax
            Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
            Route::put('/{id}', [KategoriController::class, 'update']);
            Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);               // menampilkan halaman form edit kategori Ajax
            Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);           // menyimpan perubahan data kategori Ajax
            Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);          // untuk tampilkan form confirm  delete kategori Ajax
            Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);        // untuk menghapus data kategori Ajax
            Route::delete('/{id}', [KategoriController::class, 'destroy']);
            Route::get('/import', [KategoriController::class, 'import']);                   // ajax form upload excel
            Route::post('/import_ajax', [KategoriController::class, 'import_ajax']);        // ajax import excel
            Route::get('/export_excel', [KategoriController::class, 'export_excel']); // export excel
            Route::get('/export_pdf', [KategoriController::class, 'export_pdf']);     // export pdf
        });
    });

    // artinya semua route di dalam group ini harus punya role ADM (Administrator), MNG (Manager), dan STF (Staff)
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        // Route::get('/create', [BarangController::class, 'create']);
        // Route::post('/', [BarangController::class, 'store']);

        Route::get('/barang', [BarangController::class, 'index']);
        Route::post('/barang/list', [BarangController::class, 'list']);
        Route::get('/barang/create_ajax', [BarangController::class, 'create_ajax']); // ajax form create
        Route::post('/barang_ajax', [BarangController::class, 'store_ajax']); // ajax store
        Route::get('/barang/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // ajax form edit
        Route::put('/barang/{id}/update_ajax', [BarangController::class, 'update_ajax']); // ajax update
        Route::get('/barang/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // ajax form confirm
        Route::delete('/barang/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // ajax delete       
        Route::get('/barang/import', [BarangController::class, 'import']); // ajax form upload excel
        Route::post('/barang/import_ajax', [BarangController::class, 'import_ajax']); // ajax import excel
        Route::get('/barang/export_excel', [BarangController::class, 'export_excel']); // export excel
        Route::get('/barang/export_pdf', [BarangController::class, 'export_pdf']);     // export pdf
    });
});

// artinya semua route di dalam group ini harus punya role ADM (Administrator), MNG (Manager), dan STF (Staff)
Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
    Route::group(['prefix' => 'supplier'], function () {
        Route::get('/', [SupplierController::class, 'index']);
        Route::post('/list', [SupplierController::class, 'list']);
        Route::get('/create', [SupplierController::class, 'create']);
        Route::post('/', [SupplierController::class, 'store']);
        Route::get('/{id}/edit', [SupplierController::class, 'edit']);
        Route::put('/{id}', [SupplierController::class, 'update']);
        Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);
        Route::post('/ajax', [SupplierController::class, 'store_ajax']);
        Route::get('/{id}', [SupplierController::class, 'show']);
        Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); // menampilkan halaman form edit Supplier Ajax
        Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);  // menyimpan perubahan data Supplier Ajax
        Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); // untuk tampilkan form confirm  delete Supplier Ajax
        Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // untuk menghapus data Supplier Ajax
        Route::delete('/{id}', [SupplierController::class, 'destroy']);
        Route::get('/import', [SupplierController::class, 'import']);                   // ajax form upload excel
        Route::post('/import_ajax', [SupplierController::class, 'import_ajax']);        // ajax import excel
        Route::get('/export_excel', [SupplierController::class, 'export_excel']); // export excel
        Route::get('/export_pdf', [SupplierController::class, 'export_pdf']);     // export pdf
    });
});

Route::group(['prefix' => 'stok'], function () {
    Route::get('/', [StokController::class, 'index']);
    Route::post('/list', [StokController::class, 'list']);
    Route::get('/create', [StokController::class, 'create']);
    Route::post('/', [StokController::class, 'store']);
    Route::get('/{id}', [StokController::class, 'show']);
    Route::get('/{id}/edit', [StokController::class, 'edit']);
    Route::put('/{id}', [StokController::class, 'update']);
    Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']); // menampilkan halaman form edit Stok Ajax
    Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']);  // menyimpan perubahan data Stok Ajax
    Route::get('/{id}/delete_ajax', [StokController::class, 'confirm_ajax']); // untuk tampilkan form confirm  delete Stok Ajax
    Route::delete('/{id}/delete_ajax', [StokController::class, 'delete_ajax']); // untuk menghapus data Stok Ajax
    Route::delete('/{id}', [StokController::class, 'destroy']);
});
