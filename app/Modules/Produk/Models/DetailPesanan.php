<?php

namespace App\Modules\Produk\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Produk\Models\Produk;
use App\Modules\Produk\Models\Pesanan;

class DetailPesanan extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'id_pesanan',
        'id_produk',
        'qty',
        'harga',
    ];

    public function order()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
