<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.index');
});

Route::get('/masuk', function () {
    return view('pages.login');
});

Route::get('/kalender', function () {
    return view('pages.kalender');
})->name('kalender');

Route::get('/kalkulator', function () {
    return view('pages.kalkulator');
})->name('kalkulator');
