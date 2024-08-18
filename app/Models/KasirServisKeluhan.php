<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasirServisKeluhan extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->profit = $model->harga_jual - ($model->harga_beli + $model->biaya);
        });
    }

    public function kasirServis()
    {
        return $this->belongsTo(KasirServis::class, 'kasir_servis_id');
    }
}
