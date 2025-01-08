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

Route::get('/login', function () {
    return view('admin.login');
})->name('login');

Route::post('/action-login', [\App\Http\Controllers\LoginController::class, 'actionLogin'])->name('action-login');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

    Route::prefix('beranda')->name('beranda.')->group(function () {
        Route::get('/index', [\App\Http\Controllers\BerandaAdminController::class, 'index'])->name('index');
        Route::get('/get-data-pasien', [\App\Http\Controllers\BerandaAdminController::class, 'get_data_pasien'])->name('get-data-pasien');
        Route::post('/update-status-pemeriksaan', [\App\Http\Controllers\BerandaAdminController::class, 'update_status_pasien'])->name('update-status-pemeriksaan');
    });

    Route::prefix('kuota')->name('kuota.')->group(function () {
        Route::get('/index', [\App\Http\Controllers\KuotaController::class, 'index'])->name('index');
        Route::post('/update-kuota', [\App\Http\Controllers\KuotaController::class, 'updateKuota'])->name('update-kuota');
    });
    


    Route::prefix('registrasi')->name('registrasi.')->group(function () {
        Route::get('/index', [\App\Http\Controllers\RegistrasiController::class, 'index'])->name('index');
        Route::post('/insert', [\App\Http\Controllers\RegistrasiController::class, 'insert'])->name('insert');
    });
});

Route::get('/get_antrian', [\App\Http\Controllers\masterController::class, 'get_antrian'])->name('get_antrian');

