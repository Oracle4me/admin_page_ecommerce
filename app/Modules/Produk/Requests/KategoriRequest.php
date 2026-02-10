<?php

namespace App\Modules\Produk\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KategoriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'nama' => 'required|string|max:50',
            'deskripsi' => 'required|string|max:225',
            'gender' => 'required|in:pria,wanita,universal',
        ];
    }
}
