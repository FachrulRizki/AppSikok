<?php

namespace App\Services;

use App\Models\Refleksi;
use Illuminate\Http\Request;

class RefleksiService
{
    public function listRefleksi($request)
    {
        $search = $request->get('search');
        $start = $request->get('start');
        $end = $request->get('end');

        $data = Refleksi::select(
            'id','waktu', 'jdl_kegiatan', 'approvement', 'nilai', 'user_id'
        )->with('user');

        if (auth()->user()->can('refleksi.lihat.sendiri')) {
            $data = $data->where('user_id', auth()->user()->id);
        }

        if (auth()->user()->hasRole('Kepala Ruang')) {
            $data = $data->whereHas('user', function ($query) {
                $query->where('unit', auth()->user()->unit);
            });
        }

        if ($search) {
            $data->where(function ($query) use ($search) {
                $query->where('jdl_kegiatan', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($start && $end) {
            $data = $data->whereDate('waktu', '>=', $start)->whereDate('waktu', '<=', $end);
        }

        return $data->latest()->paginate(10);
    }

    public function simpanRefleksi(Request $request)
    {
        Refleksi::create([
            'waktu' => $request->waktu,
            'jdl_kegiatan' => $request->jdl_kegiatan,
            'user_id' => auth()->user()->id,
            'poin_materi' => $request->poin_materi,
            'pribadi' => $request->pribadi,
            'tindakan' => $request->tindakan
        ]);

        return activity()
            ->event('Buat Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Membuat refleksi');
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

        return activity()
            ->event('Update Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Mengupdate refleksi');
    }

    public function updateApprovement(Refleksi $refleksi, Request $request)
    {
        $nilai = $request->filled('nilai') ? ($request->nilai ?? 0) : $refleksi->nilai;

        if (in_array($request->approvement, ['waiting', 'rejected'])) {
            $nilai = 0;
        }

        $dirty = [
            'feedback' => $request->filled('feedback') ? $request->feedback : $refleksi->feedback
        ];

        if ($request->approvement !== $refleksi->approvement) {
            $dirty['approvement'] = $request->approvement;

            activity()
                ->event('Update Persetujuan')
                ->causedBy(auth()->user())
                ->withProperties(['ip' => request()->ip()])
                ->log('Mengupdate persetujuan atau feedback refleksi');
        }
        
        if ($nilai !== $refleksi->nilai) {
            $dirty['nilai'] = $nilai;

            activity()
                ->event('Update Nilai')
                ->causedBy(auth()->user())
                ->withProperties(['ip' => request()->ip()])
                ->log('Mengupdate nilai refleksi');
        }

        if (!empty($dirty)) {
            $refleksi->update($dirty);
        }
    }

    public function hapusRefleksi(Refleksi $refleksi)
    {
        $refleksi->delete();

        return activity()
            ->event('Hapus Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Menghapus refleksi');
    }
}
