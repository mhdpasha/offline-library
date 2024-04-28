<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;

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

Route::controller(AuthController::class)->group(function () {
    Route::get('', 'login')->name('login')->middleware('guest');
    Route::post('auth-user', 'auth')->name('auth.verif')->middleware('guest');
    Route::post('logout', 'logout')->name('logout');
});


// <User>
Route::middleware(['auth', 'role:user,pustakawan,admin'])->group(function () {

Route::resource('dashboard', DashboardController::class);
Route::get('history', [PeminjamanController::class, 'history']);   

    // <Pustakawan>
    Route::middleware(['auth','role:pustakawan,admin'])->group(function () {
    Route::resource('peminjaman', PeminjamanController::class);

        // <Admin>
        Route::middleware(['auth','role:admin'])->group(function () {   
        Route::resource('user', UserController::class);
        Route::resource('kategori', KategoriController::class);
        Route::resource('buku', BukuController::class);
        });
    });
});


