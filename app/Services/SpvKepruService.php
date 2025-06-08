<?php

namespace App\Services;

use App\Models\SpvKepru;
use Illuminate\Http\Request;

class SpvKepruService
{
    public function getAll($request)
    {
        $search = $request->get('search');

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

        return $data->latest()->paginate(10);
    }

    public function store($request)
    {
        return SpvKepru::create([
            'waktu' => $request->waktu,
            'ruangan' => $request->ruangan,
            'shift' => $request->shift,
            'user_id' => auth()->user()->id,
            'aktivitas' => $request->aktivitas,
            'observasi' => $request->observasi,
            'perbaikan' => $request->perbaikan
        ]);
    }

    public function update(SpvKepru $spv, $data)
    {
        return $spv->update($data->all());
    }

    public function delete(SpvKepru $spv)
    {
        return $spv->delete();
    }
}
