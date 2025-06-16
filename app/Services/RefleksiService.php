<?php

namespace App\Services;

use App\Models\Refleksi;
use Illuminate\Http\Request;

class RefleksiService
{
    public function listRefleksi($request)
    {
        $search = $request->get('search');

        $data = Refleksi::select(
            'id','waktu', 'jdl_kegiatan', 'approvement', 'nilai', 'user_id'
        )->with('user');

        if (auth()->user()->can('refleksi.lihat.sendiri')) {
            $data = $data->where('user_id', auth()->user()->id);
        }

        if ($search) {
            $data->where(function ($query) use ($search) {
                $query->where('jdl_kegiatan', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        return $data->latest()->paginate(10);
    }

    public function simpanRefleksi(Request $request)
    {
        return Refleksi::create([
            'waktu' => $request->waktu,
            'jdl_kegiatan' => $request->jdl_kegiatan,
            'user_id' => auth()->user()->id,
            'poin_materi' => $request->poin_materi,
            'pribadi' => $request->pribadi,
            'tindakan' => $request->tindakan
        ]);
    }

    public function getRefleksi(Refleksi $refleksi)
    {
        return $refleksi;
    }

    public function updateRefleksi(Refleksi $refleksi, Request $request)
    {
        $refleksi->waktu = $request->waktu;
        $refleksi->jdl_kegiatan = $request->jdl_kegiatan;
        $refleksi->poin_materi = $request->poin_materi;
        $refleksi->pribadi = $request->pribadi;
        $refleksi->tindakan = $request->tindakan;
        $refleksi->approvement = 'waiting';
        $refleksi->feedback = '';
        $refleksi->save();
    }

    public function updateApprovement(Refleksi $refleksi, Request $request)
    {
        $refleksi->update($request->only([
            'approvement',
            'nilai',
            'feedback'
        ]));
    }

    public function hapusRefleksi(Refleksi $refleksi)
    {
        $refleksi->delete();
    }
}
