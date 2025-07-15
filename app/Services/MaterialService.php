<?php

namespace App\Services;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialService
{
    protected $service;
    
    public function __construct(FileService $fileService)
    {
        $this->service = $fileService;
    }

    public function listMaterial($request)
    {
        $search = $request->get('search');
        $type = $request->get('type');

        $data = Material::select('id', 'type', 'title', 'created_at', 'user_id')
            ->with('user', 'comments');

        if ($search) {
            $data = $data->where('title', 'like', '%' . $search . '%');
        }

        if ($type) {
            $data = $data->where('type', $type);
        }

        $data = $data->latest()->paginate(10);

        return $data;
    }

    public function simpanMaterial($request)
    {
        $type = $request->type;
        $source = null;

        if ($type == 'youtube') {
            $source = $request->source;
        } else if ($type == 'pdf') {
            if ($request->hasFile('source')) {
                $source = $this->service->upload($request->file('source'), 'pdf');
            }
        }

        Material::create([
            'title' => $request->title,
            'type' => $type,
            'source' => $source,
            'user_id' => auth()->user()->id,
            'content' => $request->content,
        ]);

        return activity()
            ->event('Buat Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Membuat Materi');
    }

    public function hapusMaterial($materi)
    {   
        $this->service->delete(public_path('storage/' . $materi->source));
        $materi->delete();

        return activity()
            ->event('Hapus Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Menghapus Materi');
    }

    public function getMaterial($materi)
    {
        return $materi;
    }

    public function updateMaterial($materi, $request)
    {
        $materi->title = $request->title;

        if ($request->hasFile('source')) {
            $this->service->delete(public_path('storage/' . $request->source));
            $materi->source = $this->service->upload($request->file('source'), 'pdf');
        } else {
            if ($request->source) {
                $materi->source = $request->source;
            }
        }

        $materi->content = $request->content;
        $materi->save();

        return activity()
            ->event('Update Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Mengupdate Materi');
    }
}
