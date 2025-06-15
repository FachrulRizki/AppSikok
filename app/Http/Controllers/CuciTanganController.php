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
        if (!auth()->user()->can('cuci_tangan.list')) return abort(403);

        $data = $this->service->getAll($request);

        return view('cuci_tangan.index', compact('data'));
    }

    public function create()
    {
        if (!auth()->user()->can('cuci_tangan.buat')) return abort(403);

        $activities = $this->service->getActivities();
        return view('cuci_tangan.create', compact('activities'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('cuci_tangan.buat')) return abort(403);

        $request->validate([
            'waktu' => 'required|date',
            'shift' => 'required|in:Pagi,Sore,Malam',
        ]);

        $this->service->store($request);

        return redirect()->route('cuci_tangan.index')->with('success', 'Data berhasil disimpan.');
    }

    public function show(CuciTangan $cuci_tangan)
    {
        $activities = $this->service->getActivities();
        return view('cuci_tangan.show', compact('cuci_tangan', 'activities'));
    }

    public function edit(CuciTangan $cuci_tangan)
    {
        if (!auth()->user()->can('cuci_tangan.edit')) return abort(403);

        $activities = $this->service->getActivities();

        $selectedDetails = is_string($cuci_tangan->details) ? json_decode($cuci_tangan->details, true) : ($cuci_tangan->details ?? []);
        $selectedTasks = is_string($cuci_tangan->tasks) ? json_decode($cuci_tangan->tasks, true) : ($cuci_tangan->tasks ?? []);
        $notes = is_string($cuci_tangan->notes) ? json_decode($cuci_tangan->notes, true) : ($cuci_tangan->notes ?? []);

        return view('cuci_tangan.edit', compact(
            'cuci_tangan', 
            'activities',
            'selectedDetails',
            'selectedTasks',
            'notes'
        ));
    }

    public function update(Request $request, CuciTangan $cuci_tangan)
    {
        if (!auth()->user()->can('cuci_tangan.edit')) return abort(403);

        $request->validate([
            'waktu' => 'required|date',
            'shift' => 'required|in:Pagi,Sore,Malam',
            'details' => 'nullable|array',
            'tasks' => 'nullable|array',
            'notes' => 'nullable|array',
        ]);

        $this->service->update($cuci_tangan, $request);

        return redirect()->route('cuci_tangan.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(CuciTangan $cuci_tangan)
    {
        if (!auth()->user()->can('cuci_tangan.hapus')) return abort(403);

        $this->service->delete($cuci_tangan);

        return redirect()->route('cuci_tangan.index')->with('success', 'Data berhasil dihapus.');
    }
}
