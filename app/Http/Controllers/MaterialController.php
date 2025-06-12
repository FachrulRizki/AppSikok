<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialRequest;
use App\Models\Material;
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
        return view('materials.create');
    }

    public function store(MaterialRequest $request)
    {
        $request->validated();

        $this->service->simpanMaterial($request);

        return redirect()->route('materi.index')->with('success', 'Materi berhasil disimpan');
    }

    public function show(Material $materi)
    {  
        return view('materials.show', [
            'material' => $materi
        ]);
    }

    public function edit(Material $materi)
    {
        return view('materials.edit', [
            'material' => $materi
        ]);
    }

    public function update(MaterialRequest $request, Material $materi)
    {
        $request->validated();

        $this->service->updateMaterial($materi, $request);

        return redirect()->route('materi.index')->with('success', 'Materi berhasil diupdate');
    }

    public function destroy(Material $materi)
    {
        $this->service->hapusMaterial($materi);
        return redirect()->route('materi.index')->with('success', 'Materi berhasil dihapus');
    }
}
