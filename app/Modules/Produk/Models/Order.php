<?php

namespace App\Modules\Produk\Models;

use App\Modules\Produk\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'order_id', 'user_id', 'total', 'status',
        'customer_name', 'customer_email', 'customer_phone', 'customer_address',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
