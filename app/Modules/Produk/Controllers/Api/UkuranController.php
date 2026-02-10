<?php

namespace App\Modules\Produk\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Produk\Requests\UkuranRequest;
use App\Modules\Produk\Resources\UkuranResource;
use App\Modules\Produk\Repositories\UkuranRepository;

class UkuranController extends Controller
{
    public function __construct(
        protected UkuranRepository $repo,
    ) {}

    public function view()
    {
        return response()->json([
            'data' => UkuranResource::collection(
                $this->repo->getAllData()
            ),
        ]);
    }

    public function store(UkuranRequest $request)
    {
        $data = $this->repo->store($request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'Ukuran produk berhasil ditambahkan.',
            'data' => new UkuranResource($data),
        ]);
    }

    public function update(UkuranRequest $request, $id)
    {
        $data = $this->repo->update($id, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Ukuran produk berhasil diperbarui',
            'data' => new UkuranResource($data),
        ]);
    }

    public function destroy($id)
    {
        $this->repo->delete($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Ukuran produk berhasil dihapus!',
        ]);
    }
}
