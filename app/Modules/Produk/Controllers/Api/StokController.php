<?php

namespace App\Modules\Produk\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Produk\Requests\StokRequest;
use App\Modules\Produk\Resources\StokResource;
use App\Modules\Produk\Repositories\StokRepository;

class StokController extends Controller
{
    public function __construct(
        protected StokRepository $repo,
    ) {}

    public function view()
    {
        return response()->json([
            'data' => StokResource::collection(
                $this->repo->view()
            ),
        ]);
    }

    public function store(StokRequest $request)
    {
        $data = $request->validated();
        $this->repo->store($data);
        return redirect()
            ->route('stok-inventory.index')
            ->with('success', 'Stok berhasil ditambahkan.');
    }

    public function update(StokRequest $request, $id)
    {
        $this->repo->find($id);
        $stok = $this->repo->update($id, $request->validated());
        return redirect()
            ->route('stok-inventory.index')
            ->with('success', 'Stok berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Stok berhasil dihapus.',
        ]);
    }
}
