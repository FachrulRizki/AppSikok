<?php

namespace App\Http\Controllers;

use App\Models\CuciTangan;
use Illuminate\Http\Request;
use App\Services\CuciTanganService;

class CuciTanganController extends Controller
{
    protected $service;

    public function __construct(CuciTanganService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $data = $this->service->getAll($request);

        return view('cuci_tangan.index', compact('data'));
    }

    public function create()
    {
        return view('cuci_tangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'waktu' => 'required|date',
            'ruangan' => 'required|string',
            'shift' => 'required|in:Pagi,Sore,Malam',
            'dilaksanakan' => 'required|array',
            'catatan' => 'nullable|array'
        ]);

        $this->service->store($request);

        return redirect()->route('cuci_tangan.index')->with('success', 'Data berhasil disimpan.');
    }

    public function show(CuciTangan $cuci_tangan)
    {
        return view('cuci_tangan.show', compact('cuci_tangan'));
    }

    public function edit(CuciTangan $cuci_tangan)
    {
        return view('cuci_tangan.edit', compact('cuci_tangan'));
    }

    public function update(Request $request, CuciTangan $cuci_tangan)
    {
        $request->validate([
            'waktu' => 'required|date',
            'ruangan' => 'required|string',
            'shift' => 'required|in:Pagi,Sore,Malam',
            'dilaksanakan' => 'required|array',
            'catatan' => 'nullable|array'
        ]);

        $this->service->update($cuci_tangan, $request);

        return redirect()->route('cuci_tangan.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(CuciTangan $cuci_tangan)
    {
        $this->service->delete($cuci_tangan);

        return redirect()->route('cuci_tangan.index')->with('success', 'Data berhasil dihapus.');
    }
}
