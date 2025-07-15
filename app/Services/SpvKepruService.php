<?php

namespace App\Services;

use App\Models\SpvKepru;
use Illuminate\Http\Request;

class SpvKepruService
{
    public function getAll($request)
    {
        $search = $request->get('search');
        $start = $request->get('start');
        $end = $request->get('end');

        $data = SpvKepru::select(
            'id','waktu', 'ruangan', 'shift', 'user_id'
        )->with('user');

        if (auth()->user()->can('supervisi_kepru.lihat.sendiri')) {
            $data = $data->where('user_id', auth()->user()->id);
        }
        
        if ($search) {
            $data->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        if ($start && $end) {
            $data = $data->whereDate('waktu', '>=', $start)->whereDate('waktu', '<=', $end);
        }

        return $data->latest()->paginate(10);
    }

    public function store($request)
    {
        SpvKepru::create([
            'waktu' => $request->waktu,
            'ruangan' => $request->ruangan,
            'shift' => $request->shift,
            'user_id' => auth()->user()->id,
            'aktivitas' => $request->aktivitas,
            'observasi' => $request->observasi,
            'perbaikan' => $request->perbaikan
        ]);

        return activity()
            ->event('Buat Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Membuat Supervisi Kepru');
    }

    public function update(SpvKepru $spv, $data)
    {
        $spv->update($data->all());

        return activity()
            ->event('Update Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Mengupdate Supervisi Kepru');
    }

    public function delete(SpvKepru $spv)
    {
        $spv->delete();

        return activity()
            ->event('Hapus Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Menghapus Supervisi Kepru');
    }
}
