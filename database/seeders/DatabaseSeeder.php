<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Produk::factory(9)->create();

        // Produk::create([
        //     'kode_produk' => '0124121',
        //     'nama_produk' => 'Nama produk',
        //     'id_kategori' => 7,
        //     'merk' => 'Merk',
        //     'harga_beli' => 10000,
        //     'harga_jual' => 15000,
        //     'diskon' => 0,
        //     'stok' => 10,
        // ]);
    }
}
