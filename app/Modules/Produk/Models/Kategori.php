<?php

namespace App\Modules\Produk\Models;
use App\Modules\Produk\Models\Produk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'gender',
    ];

    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_kategori');
    }
}
