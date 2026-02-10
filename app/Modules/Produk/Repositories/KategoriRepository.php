<?php

namespace App\Modules\Produk\Repositories;

use App\Modules\Produk\Models\Kategori;

class KategoriRepository
{
    
    public function find($id)
    {
        return Kategori::findOrFail($id);
    }

    // View all data
    public function view()
    {
        return Kategori::latest()->get();
    }

    // Store produk
    public function store(array $data)
    {
        return Kategori::create($data);
    }

    // Update base on Id
    public function update(int $id, array $data)
    {
        $produk = Kategori::findOrFail($id);
        $produk->update($data);

        return $produk->refresh();
    }

    // Delete base on Id
    public function delete($id)
    {
        $produk = $this->find($id);

        return $produk->delete();
    }
}
