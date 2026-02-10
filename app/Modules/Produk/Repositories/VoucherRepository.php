<?php

namespace App\Modules\Produk\Repositories;
use App\Modules\Produk\Models\Voucher;
use Carbon\Carbon;

class VoucherRepository
{
    public function view()
    {
        return Voucher::latest()->get();
    }

    public function find($id)
    {
        return Voucher::findOrFail($id);
    }

    public function store(array $data)
    {
        $data['starts_at'] = Carbon::parse($data['starts_at'])->startOfDay();
        $data['expires_at'] = Carbon::parse($data['expires_at'])->endOfDay();

        return Voucher::create($data);
    }

    public function update(int $id, array $data)
    {
        $data['starts_at'] = Carbon::parse($data['starts_at'])->startOfDay();
        $data['expires_at'] = Carbon::parse($data['expires_at'])->endOfDay();

        $voucher = Voucher::findOrFail($id);
        $voucher->update($data);

        return $voucher->refresh();
    }

    public function delete($id)
    {
        $voucher = Voucher::findOrFail($id);

        return $voucher->delete();
    }
}
