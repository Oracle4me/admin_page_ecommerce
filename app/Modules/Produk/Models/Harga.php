<?php

namespace App\Modules\Produk\Models;
use App\Modules\Produk\Models\Produk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'id_produk',
        'harga',
        'mata_uang',
    ];

    public function produk()
    {
        return $this->hasMany(Produk::class);
    }
}
