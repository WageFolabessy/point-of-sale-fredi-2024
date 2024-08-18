<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KasirAksesorisController;
use App\Http\Controllers\KasirPulsaPaketController;
use App\Http\Controllers\KasirServisController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanAksesorisController;
use App\Http\Controllers\LaporanPulsaPaket;
use App\Http\Controllers\LaporanServisController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TampilPenjualanController;
use App\Models\KasirPulsaPaket;
use App\Models\KasirServis;
use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::get('/login', function () {
    return view('pages.login');
})->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login');


Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        $pulsa_paket = KasirPulsaPaket::whereDate('created_at', today())->count();
        $aksesoris = Penjualan::whereDate('created_at', today())->count();
        $servis = KasirServis::whereDate('created_at', today())->count();
        $totalTransaksiHariIni = intval($pulsa_paket) + intval($aksesoris) + intval($servis);

        $keuntungan = DB::table('detail_penjualans')
            ->join('produks', 'detail_penjualans.id_produk', '=', 'produks.id')
            ->select(DB::raw('SUM(keuntungan) as total_keuntungan'))
            ->whereDate('detail_penjualans.created_at', today())
            ->first();
        $keuntungan_pulsa_paket = DB::table('kasir_pulsa_pakets')
            ->select(DB::raw('SUM(profit) as total_keuntungan'))
            ->whereDate('kasir_pulsa_pakets.created_at', today())
            ->first();

        $keuntungan_servis = DB::table('kasir_servis_keluhans')
            ->select(DB::raw('SUM(profit) as total_keuntungan'))
            ->whereDate('kasir_servis_keluhans.created_at', today())
            ->first();

        $total_keuntungan = $keuntungan->total_keuntungan + $keuntungan_pulsa_paket->total_keuntungan + $keuntungan_servis->total_keuntungan;

        return view('pages.index', compact('totalTransaksiHariIni', 'total_keuntungan'));
    });

    Route::get('/kalender', function () {
        return view('pages.kalender');
    })->name('kalender');

    Route::get('/kalkulator', function () {
        return view('pages.kalkulator');
    })->name('kalkulator');

    Route::get('/kelola_akun', function () {
        return view('pages.user');
    })->name('kelola_akun');

    Route::get('/kasir_pulsa_paket', function () {
        return view('pages.kasir-pulsa-paket');
    })->name('kasir_pulsa_paket');

    Route::get('/kasir_servis', function () {
        return view('pages.kasir-servis');
    })->name('kasir_servis');

    Route::get('/laporan_pulsa_paket', function () {
        return view('pages.laporan-pulsa-paket');
    })->middleware('can:admin')->name('laporan_pulsa_paket');

    Route::get('/laporan_aksesoris', function () {
        return view('pages.laporan-aksesoris');
    })->middleware('can:admin')->name('laporan_aksesoris');

    Route::get('/laporan_servis', function () {
        return view('pages.laporan-servis');
    })->middleware('can:admin')->name('laporan_servis');

    Route::get('/kategori', function () {
        return view('pages.kategori');
    })->middleware('can:admin')->name('kategori');

    Route::get('/produk', function () {
        return view('pages.produk');
    })->middleware('can:admin')->name('produk');

    Route::get('/pengeluaran', function () {
        return view('pages.pengeluaran');
    })->middleware('can:admin')->name('pengeluaran');

    Route::get('/pembelian', function () {
        return view('pages.pembelian');
    })->middleware('can:admin')->name('pembelian');

    Route::get('/notifications/mark-as-read', function(){
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai sudah dibaca.');
    })->name('notifications.markAllAsRead');

    Route::controller(AuthController::class)->group(function () {
        Route::post('/logout', 'logout')->name('logout');
        Route::get('/akun/datatables/', 'index');
        Route::post('/akun/tambah_akun', 'store')->middleware('can:admin');
        Route::get('/akun/edit_akun/{id}', 'edit');
        Route::post('/akun/update_akun/{id}', 'update');
        Route::delete('/akun/hapus_akun/{id}', 'destroy')->middleware('can:admin');
    });

    Route::controller(KasirPulsaPaketController::class)->group(function () {
        Route::get('/kasir_pulsa_paket/datatables/', 'index');
        Route::post('/kasir_pulsa_paket/tambah_transaksi', 'store');
        Route::get('/kasir_pulsa_paket/edit_transaksi/{id}', 'edit');
        Route::post('/kasir_pulsa_paket/update_transaksi/{id}', 'update');
        Route::delete('/kasir_pulsa_paket/hapus_transaksi/{id}', 'destroy');
    });

    Route::controller(KasirServisController::class)->group(function () {
        Route::get('/kasir_servis/datatables/', 'index');
        Route::post('/kasir_servis/tambah_transaksi', 'store');
        Route::get('/kasir_servis/edit_transaksi/{id}', 'edit');
        Route::post('/kasir_servis/update_transaksi/{id}', 'update');
        Route::delete('/kasir_servis/hapus_transaksi/{id}', 'destroy');
    });

    Route::controller(LaporanPulsaPaket::class)->group(function () {
        Route::get('/laporan_pulsa_paket/datatables/', 'index');
        Route::get('/laporan_pulsa_paket/pdf/{startDate}/{endDate}', 'generatePdf')->name('pulsa_paket_pdf');
    })->middleware('can:admin');

    Route::controller(LaporanAksesorisController::class)->group(function () {
        Route::get('/laporan_aksesoris/datatables/', 'index');
        Route::get('/laporan_aksesoris/pdf/{startDate}/{endDate}', 'generatePdf')->name('aksesoris_pdf');
    })->middleware('can:admin');

    Route::controller(LaporanServisController::class)->group(function () {
        Route::get('/laporan_servis/datatables/', 'index');
        Route::get('/laporan_servis/pdf/{startDate}/{endDate}', 'generatePdf')->name('servis_pdf');
    })->middleware('can:admin');

    Route::controller(KategoriController::class)->group(function () {
        Route::get('/kategori/datatables/', 'index');
        Route::post('/kategori/tambah_kategori', 'store');
        Route::get('/kategori/edit_kategori/{id}', 'edit');
        Route::post('/kategori/update_kategori/{id}', 'update');
        Route::delete('/kategori/hapus_kategori/{id}', 'destroy');
    })->middleware('can:admin');

    Route::controller(ProdukController::class)->group(function () {
        Route::get('/produk/datatables/', 'index');
        Route::get('/produk/kategori_list/', 'kategoriList');
        Route::post('/produk/tambah_produk', 'store');
        Route::get('/produk/edit_produk/{id}', 'edit');
        Route::post('/produk/update_produk/{id}', 'update');
        Route::delete('/produk/hapus_produk/{id}', 'destroy');
        Route::post('/produk/hapusBanyak_produk', 'massDelete')->name('hapusBanyak');
        Route::post('/produk/cetak_barcode', 'cetakBarcode')->name('cetakBarcode');
    })->middleware('can:admin');

    Route::controller(KasirAksesorisController::class)->group(function () {
        Route::get('/kasir_aksesoris', 'index')->name('kasir_aksesoris');
        Route::post('/add-product', 'addProduct')->name('addProduct');
        Route::post('/update-quantity', 'updateQuantity')->name('updateQuantity');
        Route::post('/simpan-transaksi', 'simpanTransaksi');
        Route::get('/cetak-nota/{id}', 'cetakNota')->name('cetak.nota');

    });

    Route::controller(TampilPenjualanController::class)->group(function () {
        Route::get('/detail_penjualan', 'index')->name('penjualan');
        Route::get('/penjualan/datatables/', 'penjualanDataTables');
        Route::get('/penjualan/{id}/detail', 'getDetailPenjualan');
        Route::delete('/penjualan/{id}', 'destroy')->name('penjualan.hapus');
    })->middleware('can:admin');

    Route::controller(PengeluaranController::class)->group(function () {
        Route::get('/pengeluaran/datatables/', 'index');
        Route::post('/pengeluaran/tambah_pengeluaran', 'store');
        Route::get('/pengeluaran/edit_pengeluaran/{id}', 'edit');
        Route::post('/pengeluaran/update_pengeluaran/{id}', 'update');
        Route::delete('/pengeluaran/hapus_pengeluaran/{id}', 'destroy');
    })->middleware('can:admin');

    Route::controller(PembelianController::class)->group(function () {
        Route::get('/pembelian/datatables/', 'index');
        Route::post('/pembelian/tambah_pembelian', 'store');
        Route::get('/pembelian/edit_pembelian/{id}', 'edit');
        Route::post('/pembelian/update_pembelian/{id}', 'update');
        Route::delete('/pembelian/hapus_pembelian/{id}', 'destroy');
    })->middleware('can:admin');
});
