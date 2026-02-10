<?php

namespace App\Modules\Produk\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    //
    use hasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_amount',
        'max_use',
        'used_count',
        'starts_at',
        'expires_at',
        'status',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
