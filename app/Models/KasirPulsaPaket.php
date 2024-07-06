<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasirPulsaPaket extends Model
{
    protected $fillable = ['nomor_hp', 'harga_beli', 'harga_jual', 'profit', 'keterangan'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->profit = $model->harga_jual - $model->harga_beli;
        });
    }
}
