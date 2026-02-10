<?php

namespace App\Modules\Produk\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Produk\Requests\KeranjangRequest;
use App\Modules\Produk\Models\Voucher;

class KeranjangController extends Controller
{
    public function applyVoucher(KeranjangRequest $request)
    {
        $codeVoucher = $request->validated();
        $voucher = Voucher::where('code', $codeVoucher->code)
            ->where('status', 'active')
            ->first();

        if (! $voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Voucher tidak valid atau sudah kadaluarsa',
            ], 400);
        }

        // Hitung subtotal
        $cart = $request->cart;
        $subtotal = collect($cart)->sum(function ($item) {
            return $item['harga'] * $item['qty'];
        });

        // Hitung diskon
        $discount = 0;
        if ($voucher->type === 'percent') {
            $discount = $subtotal * ($voucher->value / 100);
        } else {
            $discount = $voucher->value;
        }

        $total = max($subtotal - $discount, 0);

        return response()->json([
            'success' => true,
            'discount' => $discount,
            'subtotal' => $subtotal,
            'total' => $total,
            'voucher' => $voucher->code,
            'message' => 'Voucher berhasil diterapkan',
        ]);
    }
}
