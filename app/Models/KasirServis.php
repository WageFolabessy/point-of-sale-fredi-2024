<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasirServis extends Model
{
    use HasFactory;

    protected $table = 'kasir_servis';

    public function kasirServisKeluhans()
    {
        return $this->hasMany(KasirServisKeluhan::class, 'kasir_servis_id');
    }
}
