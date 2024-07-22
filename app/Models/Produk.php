<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class Produk extends Model
{
    use HasFactory;

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->kode_produk = self::generateUniqueKodeProduk();
        });
    }

    public static function generateUniqueKodeProduk()
    {
        $faker = Faker::create();
        do {
            $kode_produk = $faker->unique()->ean13;
        } while (self::where('kode_produk', $kode_produk)->exists());

        return $kode_produk;
    }
}
