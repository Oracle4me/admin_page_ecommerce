<?php

namespace App\Modules\Produk\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Modules\Produk\Models\Brand;
use App\Modules\Produk\Models\Kategori;
use App\Modules\Produk\Models\Produk;

class ProdukViewController extends Controller
{   

    public function dashboard()
    {
        return view('admin.dashboard');
    }
    
    public function produk()
    {
        return view('admin.daftar_produk');
    }

    public function viewProdukDetail($slug)
    {
        $produk = Produk::with(['inventory', 'kategori', 'brand'])->where('slug', $slug)->first();

        if (! $produk) {
            return response()->json([
                'status' => false,
                'message' => 'Produk tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $produk->id,
                'slug' => $produk->slug,
                'nama' => $produk->nama,
                'deskripsi' => $produk->deskripsi,
                'harga' => (int) $produk->harga,
                'stok' => $produk->inventory->qty,
                'sku' => $produk->sku,
                'image_url' => asset('storage/'.$produk->imageUrl),
                'kategori' => $produk->kategori?->nama,
                'brand' => $produk->brand?->nama,
                'warna' => $produk->warna ?? [],
                'ukuran' => $produk->ukuran ?? [],
                'tags' => explode(',', $produk->tags),
                'created_at' => $produk->created_at->format('Y-m-d'),
            ],
        ]);
    }

    public function tambahProduk()
    {
        $kategoris = Kategori::all();
        $brands = Brand::all();

        return view('admin.tambah_produk', compact('kategoris', 'brands'));
    }

    public function kategori()
    {
        return view('admin.kategori_produk');
    }

    public function brand()
    {
        return view('admin.brand_produk');
    }

    public function ukuran()
    {
        return view('admin.ukuran_produk');
    }

    public function warna()
    {
        return view('admin.warna_produk');
    }

    public function stokInventory()
    {
        return view('admin.stok_produk');
    }

    public function voucher()
    {
        return view('admin.voucher_produk');
    }

    public function order()
    {
        return view('admin.order_produk');
    }
}
