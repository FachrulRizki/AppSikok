<?php

namespace App\Services;

use App\Models\AktivitasKeperawatan;
use Illuminate\Http\Request;

class AktivitasKeperawatanService
{
    public function listAktivitas()
    {
        return AktivitasKeperawatan::latest()->get();
    }

    public function simpanAktivitas(Request $request)
    {
        return AktivitasKeperawatan::create($request->all());
    }

    public function updateAktivitas(AktivitasKeperawatan $aktivitas, Request $request)
    {
        return $aktivitas->update($request->all());
    }

    public function hapusAktivitas(AktivitasKeperawatan $aktivitas)
    {
        return $aktivitas->delete();
    }
}
