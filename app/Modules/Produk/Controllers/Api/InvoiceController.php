<?php

namespace App\Modules\Produk\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Produk\Models\Order;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class InvoiceController extends Controller
{
    //
    public function show($order_id)
    {
        $order = Order::with('items')->where('order_id', $order_id)->firstOrFail();

        // Kembalikan data JSON
        return response()->json([
            'order_id' => $order->order_id,
            'status' => $order->status,
            'customer_name' => $order->customer_name,
            'customer_email' => $order->customer_email,
            'customer_phone' => $order->customer_phone,
            'customer_address' => $order->customer_address,
            'items' => $order->items->map(function ($item) {
                return [
                    'produk_nama' => $item->produk_nama,
                    'qty' => $item->qty,
                    'harga' => $item->harga,
                    'subtotal' => $item->subtotal,
                ];
            }),
            'total' => $order->total,
        ]);
    }

    public function lastInvoice(Request $request)
    {
        // Ambil user dari token JWT
        $user = JWTAuth::parseToken()->authenticate();
        $userId = $user->id;

        // Cari invoice terakhir milik user
        $order = Order::with('items')
            ->where('user_id', $userId)
            ->latest()
            ->first();

        if (!$order) {
            return response()->json(['message' => 'Invoice tidak ditemukan'], 404);
        }

        return response()->json(['order_id' => $order->order_id]);
    }
}
