<?php

namespace App\Modules\Produk\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KeranjangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'code' => 'required|string',
            'cart' => 'required|array',
            'cart.*.id' => 'required|integer',
            'cart.*.nama' => 'required|string',
            'cart.*.harga' => 'required|numeric',
            'cart.*.qty' => 'required|integer|min:1',
        ];
    }
}
