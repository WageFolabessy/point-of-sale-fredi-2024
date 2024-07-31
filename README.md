# Kumpulan Teknologi yang Digunakan untuk Membangun Website Point of Sale

Berikut adalah daftar teknologi dan pustaka yang digunakan dalam pengembangan website point of sale berdasarkan file `composer.json`.

## PHP

Website ini dibangun menggunakan PHP versi ^8.2 dan Laravel versi ^11.

## Pustaka Utama

- **barryvdh/laravel-dompdf** (^2.2): Digunakan untuk membuat dan memanipulasi file PDF.
- **laravel/framework** (^11.9): Kerangka kerja utama untuk pengembangan aplikasi web.
- **laravel/tinker** (^2.9): Memberikan antarmuka baris perintah untuk berinteraksi dengan aplikasi.
- **milon/barcode** (^11.0): Digunakan untuk menghasilkan kode batang (barcode).
- **yajra/laravel-datatables** (11.0): Alat untuk menampilkan data dalam format tabel yang interaktif.

## Pustaka Pengembangan

- **fakerphp/faker** (^1.23): Digunakan untuk menghasilkan data palsu untuk pengujian dan pengembangan.
- **laravel/pint** (^1.13): Alat untuk menjaga kode tetap bersih dan konsisten.
- **laravel/sail** (^1.26): Alat untuk menjalankan lingkungan pengembangan berbasis Docker.
- **mockery/mockery** (^1.6): Pustaka untuk membuat mock objek dalam pengujian unit.
- **nunomaduro/collision** (^8.0): Memberikan pengalaman debug yang lebih baik.
- **phpunit/phpunit** (^11.0.1): Framework pengujian unit untuk PHP.

## Autoload

- **PSR-4 autoloading**: Mengatur autoloading untuk berbagai namespace dan direktori dalam proyek.
- **File autoloading**: Memuat file khusus seperti `app/Http/Helpers/helpers.php`.

## Skrip

- **post-autoload-dump**: Memicu skrip setelah autoload dump.
- **post-update-cmd**: Menjalankan perintah setelah pembaruan paket.
- **post-root-package-install**: Skrip yang dijalankan setelah instalasi paket root.
- **post-create-project-cmd**: Perintah yang dijalankan setelah pembuatan proyek.

## Konfigurasi

- **optimize-autoloader**: Mengoptimalkan autoloading.
- **preferred-install**: Mengatur preferensi instalasi paket.
- **sort-packages**: Mengurutkan paket untuk kemudahan pemeliharaan.
- **allow-plugins**: Mengizinkan plugin tertentu.

## Stabilitas

- **minimum-stability**: Mengatur stabilitas minimum paket sebagai "stable".
- **prefer-stable**: Memilih versi stabil dari paket jika tersedia.

## Lisensi

Aplikasi ini menggunakan lisensi MIT.
