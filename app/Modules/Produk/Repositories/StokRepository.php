<?php

namespace App\Modules\Produk\Repositories;

use App\Modules\Produk\Models\Iventory as Stok;

class StokRepository
{
    public function view()
    {
        return Stok::with(['produk'])->latest()->get();
    }

    public function find($id)
    {
        return Stok::with('produk')->findOrFail($id);
    }

    public function store(array $data)
    {
        return Stok::create($data);
    }

    public function update(int $id, array $data)
    {
        $stok = Stok::findOrFail($id);
        $stok->update($data);

        return $stok->refresh();
    }

    public function delete($id)
    {
        $stok = $this->find($id);

        return $stok->delete();
    }
}
