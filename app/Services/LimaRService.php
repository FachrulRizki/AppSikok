<?php

namespace App\Services;

use App\Models\LimaR;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LimaRService
{
    public function getAll($paginate = 10)
    {
        return LimaR::latest()->paginate($paginate);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'waktu' => 'required|date',
            'shift' => 'required|string',
            'dilaksanakan' => 'required|array|size:5',
            'catatan' => 'nullable|array|size:5',
            'foto.*' => 'nullable|image|max:102400|mimetypes:image/jpeg,image/png',
        ]);

        // Simpan foto
        $fotoPaths = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $path = $file->store('foto_lima_r', 'public');
                $fotoPaths[] = $path;
            }
        }

        return LimaR::create([
            'waktu' => $validated['waktu'],
            'shift' => $validated['shift'],
            'dilaksanakan' => json_encode($validated['dilaksanakan']),
            'catatan' => json_encode($validated['catatan']),
            'foto' => $fotoPaths,
            'user_id' => auth()->id(),
        ]);
    }

    public function delete(LimaR $lima_r)
    {
        if ($lima_r->foto) {
            foreach ($lima_r->foto as $foto) {
                Storage::disk('public')->delete($foto);
            }
        }

        return $lima_r->delete();
    }

    public function getById($id)
    {
        return LimaR::findOrFail($id);
    }
}
