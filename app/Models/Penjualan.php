<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Penjualan extends Model
{
    use HasFactory;

    public function detailPenjualans()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_penjualan');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->nama_kasir = Auth::user()->nama;
        });
    }
}
