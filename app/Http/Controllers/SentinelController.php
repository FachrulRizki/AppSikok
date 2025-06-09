<?php

namespace App\Http\Controllers;

use App\Services\SentinelService;
use App\Models\Sentinel;
use Illuminate\Http\Request;

class SentinelController extends Controller
{
    public function index()
    {
        $sentinels = Sentinel::latest()->paginate(10);

        return view('datamutu.insiden.sentinel.index', compact('sentinels'));
    }

    public function create()
    {
        return view('datamutu.insiden.sentinel.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_rm' => 'required|string',
            'nama_pasien' => 'required|string',
            'umur' => 'required|string',
            'jk' => 'required|string',
            'waktu_mskrs' => 'nullable|date',
            'waktu_insiden' => 'nullable|date',
            'temuan' => 'required|string',
            'kronologis' => 'required|string',
            'unit_terkait' => 'required|string',
            'sumber' => 'required|string',
            'rawat' => 'required|string',
            'poli' => 'required|string',
            'lokasi' => 'required|string',
            'tindakan_segera' => 'required|string',
            'pelaksana' => 'required|string',
            'akibat' => 'required|string',
            'nama_inisial' => 'required|string',
            'ruangan_pelapor' => 'required|string',
            'foto.*' => 'nullable|image|max:102400|mimetypes:image/jpeg,image/png',
        ]);

        $fotoPaths = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $path = $file->store('foto_sentinel', 'public');
                $fotoPaths[] = $path;
            }
        }

        sentinel::create([
            'no_rm' => $validated['no_rm'],
            'nama_pasien' => $validated['nama_pasien'],
            'umur' => $validated['umur'],
            'jk' => $validated['jk'],
            'waktu_mskrs' => $validated['waktu_mskrs'] ?? null,
            'waktu_insiden' => $validated['waktu_insiden'] ?? null,
            'temuan' => $validated['temuan'],
            'kronologis' => $validated['kronologis'],
            'unit_terkait' => $validated['unit_terkait'],
            'sumber' => $validated['sumber'],
            'rawat' => $validated['rawat'],
            'poli' => $validated['poli'],
            'lokasi' => $validated['lokasi'],
            'tindakan_segera' => $validated['tindakan_segera'],
            'pelaksana' => $validated['pelaksana'],
            'akibat' => $validated['akibat'],
            'nama_inisial' => $validated['nama_inisial'],
            'ruangan_pelapor' => $validated['ruangan_pelapor'],
            'foto' => $fotoPaths,
        ]);

        return redirect()->route('insiden.sentinel.index')->with('success', 'Data sentinel berhasil disimpan.');
    }

    public function show($id)
    {
        $sentinel = sentinel::findOrFail($id);
        return view('datamutu.insiden.sentinel.show', compact('sentinel'));
    }

    public function destroy(sentinel $sentinel)
    {
        $sentinel->delete();
        return redirect()->route('insiden.sentinel.index')->with('success', 'Data sentinel berhasil dihapus.');
    }
}
