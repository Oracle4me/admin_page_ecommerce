<?php

namespace App\Modules\Produk\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'code' => 'required|string|max:100|unique:vouchers,code,'.$this->id,
            'type' => 'required|in:percent,nominal',
            'value' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    if ($this->type === 'percent' && ($value < 1 || $value > 100)) {
                        $fail('Value untuk  tipe percent harus antara 1 sampai 100.');
                    }
                    if ($this->type === 'nominal' && ($value < 1)) {
                        $fail('Value harus bersifat nominal mata uang');
                    }
                },
            ],
            'min_amount' => 'nullable|integer|min:0',
            'max_use' => 'nullable|integer|min:1',
            'used_count' => 'nullable|integer|min:0',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date',
            'status' => 'required|in:active,expired',
        ];
    }
}

// | Field        | Rules             | Keterangan                        |
// | ------------ | ----------------- | --------------------------------- |
// | `code`       | required, unique  | Tidak boleh duplikat              |
// | `type`       | percent / nominal | Jenis voucher                     |
// | `value`      | custom rule       | otomatis cek percent atau nominal |
// | `min_amount` | integer ≥ 0       | minimal pembelian                 |
// | `max_use`    | integer ≥ 1       | berapa kali voucher bisa dipakai  |
// | `used_count` | integer ≥ 0       | awalnya 0                         |
// | `starts_at`  | date              | opsional                          |
// | `ends_at`    | date ≥ starts_at  | tidak boleh kurang dari start     |
// | `status`     | active/expired    | enum                              |
