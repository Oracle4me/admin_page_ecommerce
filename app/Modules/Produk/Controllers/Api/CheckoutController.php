<?php

namespace App\Modules\Produk\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Produk\Models\Order;
use App\Modules\Produk\Models\OrderItem;
use App\Modules\Produk\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        // Midtrans config
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $cart = $request->input('cart', []);
        if (empty($cart)) {
            return response()->json(['message' => 'Keranjang kosong'], 400);
        }

        $items = [];
        $grossAmount = 0;

        foreach ($cart as $item) {
            $produk = Produk::find($item['id']);
            if (! $produk) {
                return response()->json(['message' => "Produk ID {$item['id']} tidak ditemukan"], 404);
            }

            if (! $produk->inventory || $produk->inventory->qty < $item['qty']) {
                return response()->json(['message' => "Stok produk {$produk->nama} tidak mencukupi"], 400);
            }

            $subtotal = $produk->harga * $item['qty'];
            $grossAmount += $subtotal;

            $items[] = [
                'id' => $produk->id,
                'price' => (int) $produk->harga,
                'quantity' => $item['qty'],
                'name' => $produk->nama,
            ];
        }

        $orderId = 'ORDER-'.Str::uuid();
        $userId = JWTAuth::parseToken()->authenticate()->id;
        $order = Order::create([
            'order_id' => $orderId,
            'user_id' => $userId,
            'total' => $grossAmount,
            'status' => 'pending',
            'customer_name' => $request->input('customer.first_name').' '.$request->input('customer.last_name'),
            'customer_email' => $request->input('customer.email'),
            'customer_phone' => $request->input('customer.phone'),
            'customer_address' => $request->input('customer.address'),
        ]);

        foreach ($cart as $item) {
            $produk = Produk::find($item['id']);
            OrderItem::create([
                'order_id' => $order->id,
                'produk_id' => $produk->id,
                'produk_nama' => $produk->nama,
                'harga' => $produk->harga,
                'qty' => $item['qty'],
                'subtotal' => $produk->harga * $item['qty'],
            ]);

            // Kurangi stok
            $produk->inventory->decrement('qty', $item['qty']);
        }

        // Midtrans Snap params
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'item_details' => $items,
            'customer_details' => [
                'first_name' => $request->input('customer.first_name'),
                'last_name' => $request->input('customer.last_name'),
                'email' => $request->input('customer.email'),
                'phone' => $request->input('customer.phone'),
            ],
            'callbacks' => [
                'finish' => url("http://localhost:8080/invoice/${orderId}"),
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json([
            'snap_token' => $snapToken,
            'client_key' => config('midtrans.client_key'),
            'order_id' => $orderId,
        ]);
    }

    // Midtrans Notification Handler
    public function notification(Request $request)
    {
        $notif = new \Midtrans\Notification;
        $order = Order::where('order_id', $notif->order_id)->first();

        if (! $order) {
            return response()->json(['message' => 'Order tidak ditemukan'], 404);
        }

        $status = $notif->transaction_status;

        if ($status == 'settlement') {
            $order->update(['status' => 'paid']);
        } elseif ($status == 'cancel' || $status == 'deny') {
            $order->update(['status' => 'failed']);
        } elseif ($status == 'pending') {
            $order->update(['status' => 'pending']);
        }

        return response()->json(['message' => 'ok']);
    }
}
