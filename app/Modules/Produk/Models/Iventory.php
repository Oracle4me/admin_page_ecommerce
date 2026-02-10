<?php

namespace App\Modules\Produk\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iventory extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'id_produk',
        'qty',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    // Status stok acurracy
    public function getStatusAttribute()
    {
        if ($this->qty <= 5) {
            return 'Low';
        }
        if ($this->qty <= 20) {
            return 'Medium';
        }

        return 'High';
    }
}
