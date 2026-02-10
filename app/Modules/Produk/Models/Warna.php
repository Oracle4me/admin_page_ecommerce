<?php

namespace App\Modules\Produk\Models;
use App\Modules\Produk\Models\Produk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warna extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_produk',
        'nama_warna',
        'kode_warna',
        'qty'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
