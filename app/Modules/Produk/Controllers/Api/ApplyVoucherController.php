<?php

namespace App\Modules\Produk\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Produk\Models\Voucher;
use Illuminate\Http\Request;

class applyVoucherController extends Controller
{
   public function applyVoucher(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'cart' => 'required|array',
            'cart.*.id' => 'required|integer',
            'cart.*.nama' => 'required|string',
            'cart.*.harga' => 'required|numeric',
            'cart.*.qty' => 'required|integer|min:1',
        ]);

        $voucher = Voucher::where('code', $request->code)
            ->where('status', 'active')
            ->whereDate('starts_at', '<=', now())
            ->whereDate('expires_at', '>=', now())
            ->first();

        if (! $voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Voucher tidak valid atau sudah kadaluarsa',
            ], 400);
        }

        // Hitung subtotal
        $subtotal = collect($request->cart)->sum(function ($item) {
            return $item['harga'] * $item['qty'];
        });

        // Validasi minimal belanja (jika ada)
        if ($voucher->min_amount && $subtotal < $voucher->min_amount) {
            return response()->json([
                'success' => false,
                'message' => 'Minimal belanja Rp ' . number_format($voucher->min_amount, 0, ',', '.'),
            ], 400);
        }

        // Hitung diskon
        if ($voucher->type === 'percent') {
            $discount = ($voucher->value / 100) * $subtotal;
        } else {
            $discount = $voucher->value;
        }

        // Diskon tidak boleh lebih besar dari subtotal
        $discount = min($discount, $subtotal);

        $total = $subtotal - $discount;

        // ✅ SIMPAN KE SESSION
        session([
            'voucher' => [
                'id' => $voucher->id,
                'code' => $voucher->code,
                'type' => $voucher->type,
                'value' => $voucher->value,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Voucher berhasil diterapkan',
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'voucher' => $voucher->code,
        ]);
    }
}
