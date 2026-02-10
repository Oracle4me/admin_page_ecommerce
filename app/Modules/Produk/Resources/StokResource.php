<?php

namespace App\Modules\Produk\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StokResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'qty' => $this->qty,
            'status' => $this->status,
            'produks' => [
                'id' => $this->produk->id,
                'nama' => $this->produk->nama,
                'brand' => $this->produk->brand->nama,
                'sku' => $this->produk->sku,
                'imageUrl' => asset('storage/'.$this->produk->imageUrl),
            ],
        ];

    }
}
