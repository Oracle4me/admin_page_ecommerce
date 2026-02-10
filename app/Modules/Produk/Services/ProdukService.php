<?php

namespace App\Modules\Produk\Services;

use App\Modules\Produk\Repositories\ProdukRepository;
use Illuminate\Support\Facades\DB;

class ProdukService
{
    protected ProdukRepository $repository;

    public function __construct(ProdukRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all data
     */
    public function getAll()
    {
        return $this->repository->all();
    }

    /**
     * Get single data by id
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Store new data
     */
    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {

            // Business logic di sini
            // contoh:
            // $data['slug'] = str()->slug($data['name']);

            return $this->repository->create($data);
        });
    }

    /**
     * Update data
     */
    public function update($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {

            return $this->repository->update($id, $data);
        });
    }

    /**
     * Delete data
     */
    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
