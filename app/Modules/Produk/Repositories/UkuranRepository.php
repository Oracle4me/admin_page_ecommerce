<?php

namespace App\Modules\Produk\Repositories;
use App\Modules\Produk\Models\Iventory;
use App\Modules\Produk\Models\Ukuran;

class UkuranRepository
{
    public function getAllData()
    {
        return Ukuran::with(['produk.inventory'])->latest()->get();
    }

    public function find($id)
    {
        return Ukuran::with('produk')->findOrFail($id);
    }

    public function store(array $data)
    {
        $produkId = $data['id_produk'];
        $qtyInput = (int) $data['qty'];
        $stokTotal = Iventory::where('id_produk', $produkId)->value('qty') ?? 0;
        $totalUkuran = Ukuran::where('id_produk', $produkId)->sum('qty');

        $sisa = $stokTotal - $totalUkuran;

        if ($qtyInput > $sisa) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'qty' => ['Stok tidak cukup. Sisa stok: '.$sisa],
            ]);
        }

        return Ukuran::create($data);
    }

    public function update(int $id, array $data)
    {
        $stok = Ukuran::findOrFail($id);
        $stok->update($data);

        return $stok->refresh();
    }

    public function delete($id)
    {
        $stok = $this->find($id);
        return $stok->delete();
    }
}
