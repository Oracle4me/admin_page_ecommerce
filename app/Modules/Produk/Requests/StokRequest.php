<?php

namespace App\Modules\Produk\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StokRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'id_produk' => [
                'required',
                Rule::unique('iventories')
                    ->where(function ($q) {
                        return $q->where('id_produk', $this->id_produk);
                    }),
            ],
            'qty' => 'nullable|integer|min:1',
        ];
    }

        public function messages()
    {
        return [
            'id_produk.required' => 'Produk wajib dipilih.',
            'id_produk.unique'   => 'Stok untuk produk ini sudah ada.',
            'qty.required'    => 'Jumlah stok wajib diisi.',
            'qty.integer'     => 'Jumlah stok harus berupa angka.',
            'qty.min'         => 'Jumlah stok minimal 1.',
        ];
    }

}
