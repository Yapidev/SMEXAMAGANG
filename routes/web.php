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
        Route::get('list-siswa', 'index')->name('siswa.index');
        Route::post('create-siswa', 'create')->name('siswa.create');
        Route::get('edit-siswa/{siswa}', 'edit')->name('siswa.edit');
        Route::put('update-siswa/{siswa}', 'update')->name('siswa.update');
        Route::delete('destroy-siswa/{siswa}', 'destroy')->name('siswa.destroy');
        Route::post('import-siswa-csv', 'importCsv')->name('siswa.import');
    });

    // Route Controller Pembimbing
    Route::controller(PembimbingController::class)->group(function () {
        Route::get('list-pembimbing', 'index')->name('pembimbing.index');
        Route::post('list-pembimbing', 'store')->name('pembimbing.store');
        Route::put('list-pembimbing/{id}', 'update')->name('pembimbing.update');
        Route::delete('list-pembimbing/{id}', 'destroy')->name('pembimbing.destroy');
    });

    // Route Controller Prakerin
    Route::controller(PrakerinController::class)->group(function () {
        Route::get('prakerin', 'index')->name('prakerin.index');
        Route::post('prakerin', 'store')->name('prakerin.store');
        Route::put('prakerin/{id}', 'update')->name('prakerin.update');
        Route::delete('prakerin/{id}', 'destroy')->name('prakerin.destroy');
    });

    // Route Controller Tempat Prakerin
    Route::controller(TempatPrakerinController::class)->group(function () {
        Route::get('tempatPrakerin', 'index')->name('tempatPrakerin.index');
        Route::post('tempatPrakerin/store', 'store')->name('tempatPrakerin.store');
        Route::put('tempatPrakerin/update/{id}', 'update')->name('tempatPrakerin.update');
        Route::delete('tempatPrakerin/{id}', 'destroy')->name('tempatPrakerin.destroy');
    });
});
