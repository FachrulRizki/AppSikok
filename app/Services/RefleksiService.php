<?php

namespace App\Services;

use App\Models\Refleksi;
use Illuminate\Http\Request;

class RefleksiService
{
    public function listRefleksi()
    {
        return Refleksi::orderBy('waktu', 'desc')->get();
    }

    public function simpanRefleksi(Request $request)
    {
        return Refleksi::create($request->all());
    }

    public function updateRefleksi(Refleksi $refleksi, Request $request)
    {
        $refleksi->update($request->all());
    }

    public function hapusRefleksi(Refleksi $refleksi)
    {
        $refleksi->delete();
    }
}
