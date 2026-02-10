<?php

namespace App\Http\Controllers\Produk;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    /**
     * Checkout cart
     */
    public function checkout(Request $request)
    {
        $cart = $request->input('cart', []);

        if (empty($cart)) {
            return response()->json(['success' => false, 'message' => 'Cart kosong!'], 400);
        }

        // Hitung total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['harga'] * $item['qty'];
        }

        // Simpan ke tabel pesanans
        $pesanan = Pesanan::create([
            'id_user' => $request->user()->id ?? null, // optional
            'total' => $total,
            'status' => 'pending',
        ]);

        // Simpan detail pesanan
        foreach ($cart as $item) {
            DetailPesanan::create([
                'id_pesanan' => $pesanan->id,
                'id_produk' => $item['id'],
                'qty' => $item['qty'],
                'harga' => $item['harga'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Checkout berhasil!',
            'pesanan_id' => $pesanan->id,
        ]);
    }
}
