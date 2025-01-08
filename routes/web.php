<?php

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
    return view('beranda');
});

Route::get('/beranda', function () {
    return view('beranda');
})->name('beranda');


Route::get('/pendaftaran', function () {
    return view('pendaftaran');
})->name('pendaftaran');

Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {
    Route::post('/insert', [\App\Http\Controllers\pendaftaranController::class, 'insert'])->name('insert');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('login')->name('login.')->group(function () {
        Route::get('/index', [\App\Http\Controllers\LoginController::class, 'index'])->name('index');
    });

    Route::prefix('registrasi')->name('registrasi.')->group(function () {
        Route::get('/index', [\App\Http\Controllers\RegistrasiController::class, 'index'])->name('index');
        Route::post('/insert', [\App\Http\Controllers\RegistrasiController::class, 'insert'])->name('insert');
    });
});

Route::get('/get_antrian', [\App\Http\Controllers\masterController::class, 'get_antrian'])->name('get_antrian');

