<?php

namespace App\Modules\Produk\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VoucherResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'type' => $this->type,
            'value' => $this->value,
            'min_amount' => $this->min_amount,
            'max_use' => $this->max_use,
            'used_count' => $this->used_count,
            'starts_at' => $this->starts_at,
            'expires_at' => $this->expires_at,
            'status' => $this->status,
        ];
    }
}
