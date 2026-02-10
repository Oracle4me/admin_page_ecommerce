<?php

namespace App\Modules\Produk\Models;

use App\Modules\Produk\Models\DetailPesanan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'total',
        'status',
    ];

    public function details()
    {
        return $this->hasMany(DetailPesanan::class);
    }
}
