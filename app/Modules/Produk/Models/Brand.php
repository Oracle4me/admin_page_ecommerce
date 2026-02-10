<?php

namespace App\Modules\Produk\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'logo',
    ];

    // hasMany karena brand memiliki banyak produk
    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_brand');
    }
}
