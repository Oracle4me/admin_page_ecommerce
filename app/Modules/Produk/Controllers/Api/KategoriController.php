<?php

namespace App\Modules\Produk\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Produk\Requests\KategoriRequest;
use App\Modules\Produk\Resources\KategoriResource;
use App\Modules\Produk\Repositories\KategoriRepository;

class KategoriController extends Controller
{

    public function __construct(
        protected KategoriRepository $repo,
    ) {}

    public function index()
    {
        return view('admin.kategori_produk');
    }

    public function view()
    {
        return response()->json([
            'data' => KategoriResource::collection(
                $this->repo->view()
            ),
        ]);
    }

    public function store(KategoriRequest $request)
    {
        $this->repo->store($request->validated());
        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(KategoriRequest $request, $id)
    {
        $this->repo->update($id, $request->validated());
        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Kategori berhasil dihapus!',
        ]);

    }
}
