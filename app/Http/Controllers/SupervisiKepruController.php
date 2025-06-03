<?php

namespace App\Http\Controllers;

use App\Models\SpvKepru;
use Illuminate\Http\Request;
use App\Services\SpvKepruService;
use Illuminate\Support\Facades\Auth;

class SupervisiKepruController extends Controller
{
    protected $service;

    public function __construct(SpvKepruService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data = $this->service->getAll();
        return view('spv_kepru.index', compact('data'));
    }

    public function create()
    {
        return view('spv_kepru.create', [
            'route' => route('spv_kepru.store'),
            'method' => 'POST'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'waktu' => 'required|date',
            'nm_kepru' => 'required|string',
            'shift' => 'required|string',
            'aktivitas' => 'array',
            'observasi' => 'nullable|string',
            'perbaikan' => 'nullable|string',
        ]);

        $this->service->store($validated);
        return redirect()->route('spv_kepru.index')->with('success', 'Data berhasil disimpan.');
    }

    public function edit(SpvKepru $spv_kepru)
    {
        return view('spv_kepru.edit', [
            'spv_kepru' => $spv_kepru,
            'route' => route('spv_kepru.update', $spv_kepru->id),
            'method' => 'PUT'
        ]);
    }

    public function update(Request $request, SpvKepru $spv_kepru)
    {
        $validated = $request->validate([
            'waktu' => 'required|date',
            'nm_kepru' => 'required|string',
            'shift' => 'required|string',
            'aktivitas' => 'array',
            'observasi' => 'nullable|string',
            'perbaikan' => 'nullable|string',
        ]);

        $this->service->update($spv_kepru, $validated);
        return redirect()->route('spv_kepru.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(SpvKepru $spv_kepru)
    {
        $this->service->delete($spv_kepru);
        return redirect()->route('spv_kepru.index')->with('success', 'Data berhasil dihapus.');
    }
}
