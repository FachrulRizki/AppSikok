<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialRequest;
use App\Models\Material;
use App\Models\MaterialComment;
use App\Services\MaterialService;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    protected $service;

    public function __construct(MaterialService $materialService)
    {
        $this->service = $materialService;
    }

    public function index(Request $request)
    {
        $data = $this->service->listMaterial($request);

        return view('materials.index', [
            'data' => $data
        ]);
    }

    public function create()
    {
        if (!auth()->user()->can('materi.buat')) return abort(403);

        return view('materials.create');
    }

    public function store(MaterialRequest $request)
    {
        if (!auth()->user()->can('materi.buat')) return abort(403);

        $request->validated();

        $this->service->simpanMaterial($request);

        return redirect()->route('materi.index')->with('success', 'Materi berhasil disimpan');
    }

    public function show(Material $materi)
    {  
        $videoEmbed = null;

        if ($materi->type == 'youtube') {
            if ($materi->source && preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^\s&]+)/', $materi->source, $matches)) {
                $videoEmbed = 'https://www.youtube.com/embed/' . $matches[1];
            }
        }

        $comments = MaterialComment::where('material_id', $materi->id)
            ->latest()
            ->paginate(5);

        return view('materials.show', [
            'material' => $materi,
            'comments' => $comments,
            'videoEmbed' => $videoEmbed
        ]);
    }

    public function edit(Material $materi)
    {
        if (auth()->user()->id != $materi->user->id) {
            return abort(403);
        }

        return view('materials.edit', [
            'material' => $materi
        ]);
    }

    public function update(MaterialRequest $request, Material $materi)
    {
        if (auth()->user()->id != $materi->user->id) {
            return abort(403);
        }

        $request->validated();

        $this->service->updateMaterial($materi, $request);

        return redirect()->route('materi.index')->with('success', 'Materi berhasil diupdate');
    }

    public function destroy(Material $materi)
    {
        if (auth()->user()->id != $materi->user->id) {
            return abort(403);
        }
        
        $this->service->hapusMaterial($materi);
        return redirect()->route('materi.index')->with('success', 'Materi berhasil dihapus');
    }

    public function loadKomentar(Request $request, Material $materi)
    {
        $comments = MaterialComment::where('material_id', $materi->id)
            ->latest()
            ->paginate(5);

        return view('components.komentar-list', compact('comments'))->render();
    }
}
