<?php

namespace App\Modules\Produk\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Produk\Requests\VoucherRequest;
use App\Modules\Produk\Repositories\VoucherRepository;
use App\Modules\Produk\Resources\VoucherResource;
use App\Modules\Produk\Models\Voucher;
use Carbon\Carbon;

class VoucherController extends Controller
{
    public function __construct(
        protected VoucherRepository $repo,
    ) {}

    public function active()
    {
       $voucher = Voucher::where('status', 'active')
            ->where('starts_at', '<=', now())
            ->where('expires_at', '>=', now())
            ->orderBy('expires_at', 'asc') // yang paling cepat habis
            ->first();

        if (!$voucher) {
            return response()->json(null);
        }

        return response()->json([
            'title' => 'Diskon Akhir Tahun',
            'description' => 'Jangan lewatkan kesempatan mendapatkan produk favoritmu!',
            'type' => $voucher->type,
            'value' => $voucher->value,
            'expires_at' => $voucher->expires_at->toIso8601String(),
        ]);
    }

    public function view()
    {
        return response()->json([
            'data' => VoucherResource::collection(
                $this->repo->view()
            ),
        ]);
    }

    public function store(VoucherRequest $request)
    {
        $this->repo->store($request->validated());
        return redirect()
            ->route('voucher.index')
            ->with('success', 'Voucher berhasil ditambahkan!');
    }

    public function update(VoucherRequest $request, $id)
    {
        $this->repo->update($id, $request->validated());
        return redirect()
            ->route('voucher.index')
            ->with('success', 'Voucher berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Voucher berhasil dihapus!',
        ]);
    }
}
