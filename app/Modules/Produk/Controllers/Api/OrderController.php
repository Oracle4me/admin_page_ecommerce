<?php

namespace App\Modules\Produk\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Produk\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function view()
    {
        $orders = Order::with('items')->latest()->get();

        return response()->json([
            'data' => $orders,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,failed,shipped,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Status order berhasil diupdate', 'status' => $order->status]);
    }

    public function last(Request $request)
    {
        $invoice = Order::where('user_id', $request->user()->id)
            ->latest()
            ->first();

        if (!$invoice) {
            return response()->json([
                'exists' => false
            ]);
        }

        return response()->json([
            'exists' => true,
            'order_id' => $invoice->order_id
        ]);
    }

    public function show($id)
    {
        $order = Order::with('items.produk')->findOrFail($id);

        return response()->json([
            'order' => $order
        ]);
    }

}
