<?php

namespace App\Modules\Produk\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UkuranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'id_produk' => 'required|exists:produks,id',
            'nama_ukuran' => 'required|string|max:50',
            'qty' => 'nullable|integer|min:0',
        ];
    }
}
