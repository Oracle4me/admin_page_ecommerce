<?php

namespace App\Modules\Produk\Resources;

use App\Modules\Produk\Models\Ukuran;
use Illuminate\Http\Resources\Json\JsonResource;

class UkuranResource extends JsonResource
{
    public function toArray($request)
    {
        $stokTotal = $this->produk?->inventory?->qty ?? 0;
        $totalUkuran = Ukuran::where('id_produk', $this->id_produk)->sum('qty');

        return [
            'id' => $this->id,
            'nama_ukuran' => $this->nama_ukuran,
            'qty' => $this->qty,
            'stok_total' => $stokTotal,
            'sisa_stok' => $stokTotal - $totalUkuran,
            'produk' => [
                'id' => $this->produk->id ?? null,
                'nama' => $this->produk->nama ?? null,
                'brand' => $this->produk->brand->nama ?? null,
                'imageUrl' => $this->produk ? asset('storage/'.$this->produk->imageUrl) : null,
            ],
        ];
    }
}
