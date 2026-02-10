<?php

namespace App\Modules\Produk\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Produk\Requests\ProdukRequest;
use App\Modules\Produk\Resources\ProdukResource;
use App\Modules\Produk\Repositories\ProdukRepository;
use App\Modules\Produk\Services\FileUploadService;

class ProdukController extends Controller
{
    public function __construct(
        protected ProdukRepository $repo,
        protected FileUploadService $fileUpload
    ) {}

    public function view()
    {
        return response()->json([
            'data' => ProdukResource::collection(
                $this->repo->view()
            ),
        ]);
    }

    public function store(ProdukRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('imageUrl')) {
            $data['imageUrl'] = $this->fileUpload->upload(
                $request->file('imageUrl')
            );
        }
        $this->repo->store($data);
        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function update(ProdukRequest $request, $id)
    {
        $produk = $this->repo->find($id);
        $data = $request->validated();
        
        if ($request->hasFile('imageUrl')) {
            $data['imageUrl'] = $this->fileUpload->replace(
                $produk->imageUrl,
                $request->file('imageUrl')
            );
        }
        
        $this->repo->update($id, $data);
        return redirect()
            ->route('produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Produk berhasil dihapus.',
        ]);
    }

    public function show($slug)
    {
      $produk = $this->repo->findBySlug($slug);

        if (!$produk) {
            return response()->json([
                'status'  => false,
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => new ProdukResource($produk)
        ]);
    }
}
