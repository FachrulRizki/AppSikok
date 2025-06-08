<?php

namespace App\Http\Controllers;

use App\Services\KtcService;
use App\Models\Ktc;
use Illuminate\Http\Request;

class KtcController extends Controller
{
    public function index()
    {
        $ktcs = Ktc::latest()->paginate(10);
        return view('datamutu.insiden.ktc.index', compact('ktcs'));
    }

    public function create()
    {
        return view('datamutu.insiden.ktc.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_rm' => 'required|string|max:100',
            'nama_pasien' => 'required|string|max:255',
            'umur' => 'required|string|max:10',
            'jk' => 'required|in:Laki-Laki,Perempuan',
            'waktu_mskrs' => 'nullable|date',
            'waktu_insiden' => 'nullable|date',
            'temuan' => 'required|string',
            'kronologis' => 'required|string',
            'unit_terkait' => 'required|string',
            'sumber' => 'required|string',
            'rawat' => 'required|string',
            'poli' => 'required|string',
            'lokasi' => 'required|string',
            'unit' => 'required|string',
            'tindakan_segera' => 'required|string',
            'pelaksana' => 'required|string',
            'nama_inisial' => 'required|string',
            'ruangan_pelapor' => 'required|string',
            'foto.*' => 'nullable|image|max:2048'
        ]);

        $fotoPaths = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $path = $file->store('foto_ktc', 'public');
                $fotoPaths[] = $path;
            }
        }

        Ktc::create([
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
            'unit' => $validated['unit'],
            'tindakan_segera' => $validated['tindakan_segera'],
            'pelaksana' => $validated['pelaksana'],
            'nama_inisial' => $validated['nama_inisial'],
            'ruangan_pelapor' => $validated['ruangan_pelapor'],
            'foto' => json_encode($fotoPaths),
        ]);

        return redirect()->route('insiden.ktc.index')->with('success', 'Data berhasil disimpan.');
    }

    public function show($id)
    {
        $ktc = ktc::findOrFail($id);
        return view('datamutu.insiden.ktc.show', compact('ktc'));
    }

    public function destroy($id)
    {
        $ktc = ktc::findOrFail($id);
        $ktc->delete();
        return redirect()->route('insiden.ktc.index')->with('success', 'Data KTC berhasil dihapus.');
    }
}
