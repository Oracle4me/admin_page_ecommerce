<?php

namespace App\Modules\Produk\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Modules\Produk\Models\Brand;
use App\Modules\Produk\Models\Iventory;
use App\Modules\Produk\Models\Kategori;
use App\Modules\Produk\Models\Order;
use App\Modules\Produk\Models\Produk;
use App\Modules\Produk\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function stats()
    {
            // Total data
        $totalProduk   = Produk::count();
        $totalVoucher  = Voucher::count();

        /**
         * Growth contoh (dummy logic tapi masuk akal)
         * Bandingkan hari ini vs kemarin
         */
        $today = Produk::whereDate('created_at', today())->count();
        $yesterday = Produk::whereDate('created_at', today()->subDay())->count();

        // hitung growth
        if ($yesterday == 0 && $today > 0) {
            $growthProduk = 100;
        } elseif ($yesterday == 0 && $today == 0) {
            $growthProduk = 0;
        } elseif ($today == 0) {
            $growthProduk = 0;
        } else {
            $growthProduk = round((($today - $yesterday) / $yesterday) * 100, 1);
        }

        $totalKategori = Kategori::count();

        $kategoriToday = Kategori::whereDate('created_at', today())->count();
        $kategoriYesterday = Kategori::whereDate('created_at', today()->subDay())->count();

        if ($kategoriYesterday == 0 && $kategoriToday > 0) {
            $growthKategori = 100;
        } elseif ($kategoriYesterday == 0) {
            $growthKategori = 0;
        } else {
            $growthKategori = round((($kategoriToday - $kategoriYesterday) / $kategoriYesterday) * 100, 1);
        }

        $totalBrand = Brand::count();

        $brandToday = Brand::whereDate('created_at', today())->count();
        $brandYesterday = Brand::whereDate('created_at', today()->subDay())->count();

        if ($brandYesterday == 0 && $brandToday > 0) {
            $growthBrand = 100;
        } elseif ($brandYesterday == 0) {
            $growthBrand = 0;
        } else {
            $growthBrand = round((($brandToday - $brandYesterday) / $brandYesterday) * 100, 1);
        }

        
        $totalVoucher = Voucher::count();

        $voucherToday = Voucher::whereDate('created_at', today())->count();
        $voucherYesterday = Voucher::whereDate('created_at', today()->subDay())->count();

        if ($voucherYesterday == 0 && $voucherToday > 0) {
            $voucherGrowth = 100;
        } elseif ($voucherYesterday == 0) {
            $voucherGrowth = 0;
        } else {
            $voucherGrowth = round((($voucherToday - $voucherYesterday) / $voucherYesterday) * 100, 1);
        }

        return response()->json([
            'total_produk'   => $totalProduk,
            'growth_produk'  => $growthProduk,
            'growth_icon'    => $growthProduk >= 0 ? 'up' : 'down',
            'growth_color'   => $growthProduk >= 0 ? 'success' : 'danger',
            'progress_produk'=> min(abs($growthProduk), 100),
            
            'total_kategori' => $totalKategori,
            'growth_kategori' => $growthKategori,
            'kategori_icon' => $growthKategori >= 0 ? 'up' : 'down',
            'kategori_color' => $growthKategori >= 0 ? 'success' : 'danger',
            'kategori_progress' => min(abs($growthKategori), 100),
            
            'total_brand'    => $totalBrand,
            'growth_brand'   => $growthBrand,
            'brand_icon'     => $growthBrand >= 0 ? 'up' : 'down',
            'brand_color'    => $growthBrand >= 0 ? 'success' : 'danger',
            'brand_progress' => min(abs($growthBrand), 100),

            'total_voucher' => $totalVoucher,
            'voucher_growth' => $voucherGrowth,
            'voucher_icon' => $voucherGrowth >= 0 ? 'up' : 'down',
            'voucher_color' => $voucherGrowth >= 0 ? 'success' : 'danger',
            'voucher_progress' => min(abs($voucherGrowth), 100),
        ]);
    }

    public function salesChart()
    {
        $orders = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as total_sales')
            )
            ->where('status','paid')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $data = $orders->map(function($item){
            return [
                'date' => $item->date,
                'total' => $item->total_sales 
            ];
        });

        return response()->json($data);
    }

    // Stock Analytics
    public function stockChart()
    {
        $stocks = Iventory::with('produk')->get(); // perbaikan typo

        $data = $stocks->map(function($item){
            return [
                'produk' => $item->produk->nama,
                'qty' => $item->qty,
                'status' => $item->status
            ];
        });

        return response()->json($data);
    }

    public function transactionSummary()
    {
        $startDate = now()->subMonth(); // misal 1 bulan terakhir
        $endDate = now();

        $orders = Order::where('status','paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $total = $orders->sum('total');

        $previousOrders = Order::where('status','paid')
            ->whereBetween('created_at', [$startDate->copy()->subMonth(), $startDate])
            ->get();
        $previousTotal = $previousOrders->sum('total');

        $change = $previousTotal == 0 ? 100 : (($total - $previousTotal) / $previousTotal) * 100;

        $trend = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total'))
            ->where('status','paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date','asc')
            ->pluck('total')
            ->toArray();

        return response()->json([
            'total' => $total,
            'change' => round($change, 2),
            'trend' => $trend
        ]);
    }

    public function topCustomers()
    {
        $startDate = now()->subMonth(); // misal 30 hari terakhir
        $endDate = now();

        // Ambil top 5 customer berdasarkan total transaksi
        $topCustomers = Order::select(
                'customer_name',
                'customer_email',
                'customer_phone',
                'customer_address',
                DB::raw('SUM(total) as total_spent'),
                DB::raw('MIN(created_at) as first_order')
            )
            ->where('status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('customer_name', 'customer_email', 'customer_phone', 'customer_address')
            ->orderByDesc('total_spent')
            ->limit(5)
            ->get();

        return response()->json($topCustomers);
    }

}