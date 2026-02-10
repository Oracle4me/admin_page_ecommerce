<?php

namespace App\Modules\Produk\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Produk\Requests\WarnaRequest;
use App\Modules\Produk\Resources\WarnaResource;
use App\Modules\Produk\Repositories\WarnaRepository;

class WarnaController extends Controller
{
    public function __construct(
        protected WarnaRepository $repo,
    ) {}

    public function view()
    {
        return response()->json([
            'data' => WarnaResource::collection(
                $this->repo->view()
            ),
        ]);
    }
    
    public function store(WarnaRequest $request)
    {
        $data = $this->repo->store($request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Warna produk berhasil ditambahkan.',
            'data' => new WarnaResource($data),
        ]);
    }

    public function update(WarnaRequest $request, $id)
    {
        $data = $this->repo->update($id, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Warna produk berhasil diperbarui',
            'data' => new WarnaResource($data),
        ]);
    }

    public function destroy($id)
    {
        $this->repo->delete($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Warna produk berhasil dihapus!',
        ]);
    }
}
