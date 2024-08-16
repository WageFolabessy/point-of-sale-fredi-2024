<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_penjualan',
        'id_produk',
        'harga_jual',
        'jumlah',
        'diskon',
        'subtotal',
        'id_penjualan',
        'id_produk',
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function getKeuntunganAttribute()
    {
        // Mengakses harga_beli dari relasi produk
        $hargaBeli = $this->produk->harga_beli;

        // Menghitung harga setelah diskon
        $hargaSetelahDiskon = $this->harga_jual - $this->diskon;

        // Menghitung keuntungan
        $keuntungan = ($hargaSetelahDiskon - $hargaBeli) * $this->jumlah;

        return $keuntungan;
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Mengakses harga_beli dari relasi produk
            $hargaBeli = $model->produk->harga_beli;

            // Menghitung harga setelah diskon
            $hargaSetelahDiskon = $model->harga_jual - $model->diskon;

            // Menghitung keuntungan
            $keuntungan = ($hargaSetelahDiskon - $hargaBeli) * $model->jumlah;

            // Menyimpan keuntungan ke dalam atribut model
            $model->keuntungan = $keuntungan;
        });
    }
}
