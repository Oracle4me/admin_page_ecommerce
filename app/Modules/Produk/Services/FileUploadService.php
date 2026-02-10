<?php

namespace App\Modules\Produk\Services;

use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function upload($file, $folder = 'produk')
    {
        return $file->store($folder, 'public');
    }

    public function replace($old, $file, $folder = 'produk')
    {
        if ($old && Storage::disk('public')->exists($old)) {
            Storage::disk('public')->delete($old);
        }

        return $this->upload($file, $folder);
    }
}
