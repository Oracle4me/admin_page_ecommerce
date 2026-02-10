<?php

namespace App\Modules\Produk\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WarnaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'id_produk' => 'required|exists:produks,id',
            'nama_warna' => 'required|string|max:30',
            'kode_warna' => 'required|string|max:10',
            'qty' => 'nullable|integer|min:0',
        ];
    }
}
