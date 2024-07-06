<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::get('/login', function () {
    return view('pages.login');
})->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login');


Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('pages.index');
    });
    Route::get('/kalender', function () {
        return view('pages.kalender');
    })->name('kalender');

    Route::get('/kalkulator', function () {
        return view('pages.kalkulator');
    })->name('kalkulator');

    Route::get('/kelola_akun', function(){
        return view('pages.user');
    })->name('kelola_akun');

    Route::controller(AuthController::class)->group(function () {
        Route::post('/logout', 'logout')->name('logout');
        Route::get('/akun/datatables/', 'index');
        Route::post('/akun/tambah_akun', 'store');
        Route::get('/akun/edit_akun/{id}', 'edit');
        Route::post('/akun/update_akun/{id}', 'update');
        Route::delete('/akun/hapus_akun/{id}', 'destroy');
    });

});
