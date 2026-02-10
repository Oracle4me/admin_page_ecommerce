<?php

namespace App\Modules\Produk\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Produk\Requests\BrandRequest;
use App\Modules\Produk\Resources\BrandResource;
use App\Modules\Produk\Repositories\BrandRepository;


class BrandController extends Controller
{

    public function __construct(
        protected BrandRepository $repo,
    ) {}

    public function view()
    {
        return response()->json([
            'data' => BrandResource::collection(
                $this->repo->view()
            ),
        ]);
    }

    public function store(BrandRequest $request)
    {
        $data = $request->validated();
        $this->repo->store($data);
        return redirect()
            ->route('brand.index')
            ->with('success', 'Brand berhasil ditambahkan!');
    }

    public function update(BrandRequest $request, $id)
    {

        $this->repo->update($id, $request->validated());
        return redirect()
            ->route('brand.index')
            ->with('success', 'Brand berhasil diperbarui');
    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Brand berhasil dihapus!',
        ]);

    }
}
