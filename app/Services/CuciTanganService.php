<?php

namespace App\Services;

use App\Models\CuciTangan;
use Illuminate\Support\Facades\Auth;

class CuciTanganService
{
    public function getAll($request)
    {
        $search = $request->get('search');

        $data = CuciTangan::select(
            'id',
            'waktu',
            'ruangan',
            'shift',
            'user_id'
        )->with('user');

        // if (auth()->user()->can('supervisi_kepru.lihat.sendiri')) {
        //     $data = $data->where('user_id', auth()->user()->id);
        // }

        if ($search) {
            $data->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        return $data->latest()->paginate(10);
    }

    public function store($request)
    {
        return CuciTangan::create([
            'waktu' => $request->waktu,
            'ruangan' => $request->ruangan,
            'shift' => $request->shift,
            'user_id' => auth()->user()->id,
            'dilaksanakan' => $request->dilaksanakan,
            'catatan' => $request->catatan
        ]);
    }

    public function update(CuciTangan $ctangan, $data)
    {
        return $ctangan->update($data->all());
    }

    public function delete(CuciTangan $ctangan)
    {
        return $ctangan->delete();
    }
}
