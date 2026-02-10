<?php

namespace App\Modules\Produk\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks';

    protected $fillable = [
        'id_kategori',
        'id_brand',
        'nama',
        'deskripsi',
        'imageUrl',
        'tags',
        'slug',
        'sku',
        'harga',
        'warna',
        'ukuran',
        'stok',
        'created_by',
        'updated_by',
    ];
     protected $casts = [
        'warna' => 'array',
        'ukuran' => 'array',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'id_brand');
    }

    public function inventory()
    {
        return $this->hasOne(Iventory::class, 'id_produk');
    }

    public function ukuran()
    {
        return $this->hasMany(Ukuran::class, 'id_produk');
    }

    public function warna()
    {
        return $this->hasMany(Warna::class, 'id_produk');
    }

    public function harga()
    {
        return $this->hasMany(Harga::class);
    }

    public function hargaTerakhir()
    {
        return $this->hasOne(Harga::class)->latestOfMany();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($produk) {
            if (empty($produk->slug)) {
                $produk->slug = Str::slug($produk->nama);

                $count = 1;
                $originalSlug = $produk->slug;
                while (Produk::where('slug', $produk->slug)->exists()) {
                    $produk->slug = $originalSlug.'-'.$count++;
                }
            }
        });
    }
}
