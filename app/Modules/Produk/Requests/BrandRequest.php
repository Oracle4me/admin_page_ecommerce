<?php

namespace App\Modules\Produk\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'nama' => 'required|string|max:225',
            'logo' => 'nullable|string',
        ];
    }
}
