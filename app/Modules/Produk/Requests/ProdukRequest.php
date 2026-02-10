<?php

namespace App\Modules\Produk\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProdukRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $produkId = $this->route('id');

        return [
            'imageUrl' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:1024'],

            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],

            'sku' => [
                'required',
                'string',
                'max:100',
                Rule::unique('produks', 'sku')->ignore($produkId),
            ],

            'id_brand' => [
                'required',
                'exists:brands,id',
            ],

            'id_kategori' => [
                'required',
                'exists:kategoris,id',
            ],

            'tags' => [
                'nullable',
                'string',
                'max:255',
            ],

            'harga' => [
                'required',
                'numeric',
                'min:0' // karena masih format "120.000"
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'imageUrl.image' => 'File harus berupa gambar.',
            'imageUrl.max' => 'Ukuran gambar maksimal 1MB.',

            'nama.required' => 'Nama produk wajib diisi.',

            'sku.required' => 'SKU wajib diisi.',
            'sku.unique' => 'SKU sudah digunakan.',

            'id_brand.required' => 'Brand wajib dipilih.',
            'id_brand.exists' => 'Brand tidak valid.',

            'id_kategori.required' => 'Kategori wajib dipilih.',
            'id_kategori.exists' => 'Kategori tidak valid.',

            'harga.required' => 'Harga wajib diisi.',
        ];
    }

    /**
     * Sanitize input sebelum dipakai controller
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('harga')) {
            $cleanHarga = str_replace('.', '', $this->harga);

            $this->merge([
                'harga' => number_format((float) $cleanHarga, 2, '.', ''),
            ]);
        }
    }
}
