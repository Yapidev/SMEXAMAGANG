<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PembimbingController;
use App\Http\Controllers\PrakerinController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TempatPrakerinController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('home', 'index')->name('home');
    });

    // Route Controller Siswa
    Route::controller(SiswaController::class)->group(function () {
        Route::get('list-siswa', 'listSiswa')->name('list-siswa');
        // Route::get('create-siswa', 'createSiswa')->name('create-siswa');
    });

    Route::controller(PembimbingController::class)->group(function () {
        Route::get('list-pembimbing', 'index')->name('pembimbing.index');
        Route::post('list-pembimbing', 'store')->name('pembimbing.store');
        Route::put('list-pembimbing/{id}', 'update')->name('pembimbing.update');
        Route::delete('list-pembimbing/{id}', 'destroy')->name('pembimbing.destroy');
    });
    Route::controller(PrakerinController::class)->group(function () {

    });
    Route::controller(TempatPrakerinController::class)->group(function () {
        Route::get('tempatPrakerin', 'index')->name('tempatPrakerin.index');
        Route::post('tempatPrakerin/store', 'store')->name('tempatPrakerin.store');
        Route::put('tempatPrakerin/{id}', 'update')->name('tempatPrakerin.update');
        Route::delete('tempatPrakerin/{id}', 'destroy')->name('tempatPrakerin.destroy');
    });
});
