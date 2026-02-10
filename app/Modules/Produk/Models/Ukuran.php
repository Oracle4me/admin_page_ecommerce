<?php

namespace App\Modules\Produk\Models;
use App\Modules\Produk\Models\Produk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ukuran extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_produk',
        'nama_ukuran',
        'qty',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
