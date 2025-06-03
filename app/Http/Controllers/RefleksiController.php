<?php

namespace App\Http\Controllers;

use App\Models\Refleksi;
use Illuminate\Http\Request;
use App\Services\RefleksiService;

class RefleksiController extends Controller
{
    protected $service;

    public function __construct(RefleksiService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data = $this->service->listRefleksi();
        return view('refleksi.index', compact('data'));
    }

    public function create()
    {
        return view('refleksi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'waktu' => 'required|date',
            'jdl_kegiatan' => 'required|string',
            'unit_kerja' => 'required|string',
            'nm_peserta' => 'required|string',
        ]);

        $this->service->simpanRefleksi($request);
        return redirect()->route('refleksi.index')->with('success', 'Data berhasil disimpan');
    }

    public function edit(Refleksi $refleksi)
    {
        return view('refleksi.edit', compact('refleksi'));
    }

    public function update(Request $request, Refleksi $refleksi)
    {
        $request->validate([
            'waktu' => 'required|date',
            'jdl_kegiatan' => 'required|string',
            'unit_kerja' => 'required|string',
            'nm_peserta' => 'required|string',
        ]);

        $this->service->updateRefleksi($refleksi, $request);
        return redirect()->route('refleksi.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(Refleksi $refleksi)
    {
        $this->service->hapusRefleksi($refleksi);
        return redirect()->route('refleksi.index')->with('success', 'Data berhasil dihapus');
    }
}
