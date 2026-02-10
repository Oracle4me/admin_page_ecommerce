<?php

namespace App\Modules\Produk\Repositories;

use App\Modules\Produk\Models\Produk;

class ProdukRepository
{
    public function view()
    {
        return Produk::with(['ukuran', 'kategori', 'brand'])->latest()->get();
    }

    public function find($id)
    {
        return Produk::findOrFail($id);
    }

    public function findBySlug(string $slug)
    {
        return Produk::where('slug', $slug)->first();
    }

    public function store(array $data)
    {
        return Produk::create($data);
    }

    public function update($id, array $data)
    {
        $model = $this->find($id);
        $model->update($data);
        return $model;
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }
}
