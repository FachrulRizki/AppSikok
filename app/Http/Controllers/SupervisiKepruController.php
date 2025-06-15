<?php

namespace App\Http\Controllers;

use App\Http\Requests\SpvKepruRequest;
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

    public function index(Request $request)
    {
        if (!auth()->user()->can('supervisi_kepru.list')) return abort(403);

        $data = $this->service->getAll($request);

        return view('spv_kepru.index', compact('data'));
    }

    public function create()
    {
        if (!auth()->user()->can('supervisi_kepru.buat')) return abort(403);

        return view('spv_kepru.create', [
            'route' => route('spv_kepru.store'),
            'method' => 'POST'
        ]);
    }

    public function store(SpvKepruRequest $request)
    {
        if (!auth()->user()->can('supervisi_kepru.buat')) return abort(403);

        $request->validated();

        $this->service->store($request);

        return redirect()->route('spv_kepru.index')->with('success', 'Supervisi berhasil disimpan.');
    }

    public function show(SpvKepru $spv_kepru)
    {
        return view('spv_kepru.show', compact('spv_kepru'));
    }

    public function edit(SpvKepru $spv_kepru)
    {
        if (!auth()->user()->can('supervisi_kepru.edit')) return abort(403);

        return view('spv_kepru.edit', [
            'spv_kepru' => $spv_kepru,
            'route' => route('spv_kepru.update', $spv_kepru->id),
            'method' => 'PUT'
        ]);
    }

    public function update(SpvKepruRequest $request, SpvKepru $spv_kepru)
    {
        if (!auth()->user()->can('supervisi_kepru.edit')) return abort(403);

        $request->validated();

        $this->service->update($spv_kepru, $request);

        return redirect()->route('spv_kepru.index')->with('success', 'Supervisi berhasil diperbarui.');
    }

    public function destroy(SpvKepru $spv_kepru)
    {
        if (!auth()->user()->can('supervisi_kepru.hapus')) return abort(403);

        $this->service->delete($spv_kepru);
        return redirect()->route('spv_kepru.index')->with('success', 'Supervisi berhasil dihapus.');
    }
}
