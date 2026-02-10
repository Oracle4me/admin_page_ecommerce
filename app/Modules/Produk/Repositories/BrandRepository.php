<?php

namespace App\Modules\Produk\Repositories;

use App\Modules\Produk\Models\Brand;

class BrandRepository
{
    public function find($id)
    {
        return Brand::findOrFail($id);
    }

    // View all data
    public function view()
    {
        return Brand::latest()->get();
    }

    // Store 
    public function store(array $data)
    {
        return Brand::create($data);
    }

    // Update base on Id
    public function update(int $id, array $data)
    {
        $produk = Brand::findOrFail($id);
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
