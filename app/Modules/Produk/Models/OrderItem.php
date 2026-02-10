<?php

namespace App\Modules\Produk\Models;
use App\Modules\Produk\Models\Produk;
use App\Modules\Produk\Models\Order;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    //
    protected $fillable = [
        'order_id', 'produk_id', 'produk_nama', 'harga', 'qty', 'subtotal',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
