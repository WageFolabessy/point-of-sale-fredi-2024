<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    Route::get('/login', function () {
        return view('pages.login');
    })->middleware('guest');

    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
});

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
});
