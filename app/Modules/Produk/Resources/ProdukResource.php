<?php

namespace App\Modules\Produk\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProdukResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
            'imageUrl' => $this->imageUrl
                ? url(Storage::url($this->imageUrl))
                : null,   
            'tags' => explode(',', $this->tags), 
            'slug' => $this->slug,
            'harga' => $this->harga,
            'sku' => $this->sku,
            'stok' => [
                'id' => optional($this->inventory)->id,
                'qty' => optional($this->inventory)->qty ?? 0,
            ],

            'ukuran' => $this->whenLoaded('ukurans', function () {
                return $this->ukurans->map(fn ($u) => [
                    'id' => $u->id,
                    'nama_ukuran' => $u->nama_ukuran,
                    'qty' => $u->qty,
                ]);
            }, []),

            'kategori' => $this->whenLoaded('kategori', function () {
                return [
                    'id' => $this->kategori->id,
                    'nama' => $this->kategori->nama,
                    'gender' => $this->kategori->gender,
                ];
            }),

            'brand' => $this->whenLoaded('brand', function () {
                return [
                    'id' => $this->brand->id,
                    'nama' => $this->brand->nama,
                ];
            }),

            'created_by' => $this->whenLoaded('createdBy', function () {
                return [
                    'id' => $this->createdBy->id,
                    'name' => $this->createdBy->name,
                ];
            }),

            'updated_by' => $this->whenLoaded('updatedBy', function () {
                return [
                    'id' => $this->updatedBy->id,
                    'name' => $this->updatedBy->name,
                ];
            }),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
