<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KasirPulsaPaketController;
use App\Http\Controllers\LaporanPulsaPaket;
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

    Route::get('/kasir_pulsa_paket', function(){
        return view('pages.kasir-pulsa-paket');
    })->name('kasir_pulsa_paket');

    Route::get('/laporan_pulsa_paket', function(){
        return view('pages.laporan-pulsa-paket');
    })->name('laporan_pulsa_paket');

    Route::controller(AuthController::class)->group(function () {
        Route::post('/logout', 'logout')->name('logout');
        Route::get('/akun/datatables/', 'index');
        Route::post('/akun/tambah_akun', 'store');
        Route::get('/akun/edit_akun/{id}', 'edit');
        Route::post('/akun/update_akun/{id}', 'update');
        Route::delete('/akun/hapus_akun/{id}', 'destroy');
    });

    Route::controller(KasirPulsaPaketController::class)->group(function () {
        Route::get('/kasir_pulsa_paket/datatables/', 'index');
        Route::post('/kasir_pulsa_paket/tambah_transaksi', 'store');
        Route::get('/kasir_pulsa_paket/edit_transaksi/{id}', 'edit');
        Route::post('/kasir_pulsa_paket/update_transaksi/{id}', 'update');
        Route::delete('/kasir_pulsa_paket/hapus_transaksi/{id}', 'destroy');
    });

    Route::controller(LaporanPulsaPaket::class)->group(function () {
        Route::get('/laporan_pulsa_paket/datatables/', 'index');
        Route::get('/laporan_pulsa_paket/pdf/{startDate}/{endDate}', 'generatePdf')->name('pulsa_paket_pdf');
    });

});
