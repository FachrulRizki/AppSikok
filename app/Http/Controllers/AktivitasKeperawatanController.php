<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AktivitasKeperawatan;
use Illuminate\Support\Facades\Auth;
use App\Services\AktivitasKeperawatanService;

class AktivitasKeperawatanController extends Controller
{
    protected $service;

    public function __construct(AktivitasKeperawatanService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data = $this->service->listAktivitas();
        return view('aktivitas_keperawatan.index', compact('data'));

        // return view('aktivitas_keperawatan/index', [
        //     'title' => 'Home Aktivitas Keperawatan',
        //     'data' => 'Halaman index'
        // ]);
    }

    public function create()
    {
        $route = route('aktivitas_keperawatan.store');
        $method = 'POST';
        return view('aktivitas_keperawatan.create', compact('route', 'method'));
    }

    public function store(Request $request)
    {
        $this->validate($request, []); // tetap validasi
        $this->service->simpanAktivitas($request);
        return redirect()->route('aktivitas_keperawatan.index')->with('success', 'Data berhasil disimpan');
    }

    public function edit(AktivitasKeperawatan $aktivitas_keperawatan)
    {
        return view('aktivitas_keperawatan.edit', compact('aktivitas_keperawatan'));
    }

    public function update(Request $request, AktivitasKeperawatan $aktivitas_keperawatan)
    {
        $this->validate($request, []);
        $this->service->updateAktivitas($aktivitas_keperawatan, $request);
        return redirect()->route('aktivitas_keperawatan.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(AktivitasKeperawatan $aktivitas_keperawatan)
    {
        $this->service->hapusAktivitas($aktivitas_keperawatan);
        return redirect()->route('aktivitas_keperawatan.index')->with('success', 'Data berhasil dihapus');
    }
}

