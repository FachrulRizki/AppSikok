<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kpc;

class KpcController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('insiden.list')) return abort(403);

        $kpcs = Kpc::latest()->paginate(10);
        
        return view('datamutu.insiden.kpc.index', compact('kpcs'));
    }

    public function create()
    {
        if (!auth()->user()->can('insiden.buat')) return abort(403);

        return view('datamutu.insiden.kpc.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('insiden.buat')) return abort(403);

        $request->validate([
            'waktu' => 'required|date',
            'temuan' => 'required|string',
            'kronologis' => 'required|string',
            'sumber' => 'required|string',
            'unit_terkait' => 'required|string',
            'ruangan' => 'required|string',
            'tindakan' => 'required|string',
            'pelaksana' => 'required|string',
            'nama_inisial' => 'required|string',
            'foto.*' => 'nullable|image|max:102400|mimetypes:image/jpeg,image/png',
        ]);

        // Upload dan simpan path foto
        $fotoPaths = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $path = $file->store('foto_kpc', 'public');
                $fotoPaths[] = $path;
            }
        }

        Kpc::create([
            'waktu' => $request->waktu,
            'temuan' => $request->temuan,
            'kronologis' => $request->kronologis,
            'sumber' => $request->sumber,
            'unit_terkait' => $request->unit_terkait,
            'ruangan' => $request->ruangan,
            'tindakan' => $request->tindakan,
            'pelaksana' => $request->pelaksana,
            'nama_inisial' => $request->nama_inisial,
            'foto' => $fotoPaths,
        ]);

        return redirect()->route('insiden.kpc.index')->with('success', 'Data insiden KPC berhasil disimpan');
    }

    public function show($id)
    {
        $kpc = Kpc::findOrFail($id);
        return view('datamutu.insiden.kpc.show', compact('kpc'));
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('insiden.hapus')) return abort(403);

        $kpc = Kpc::findOrFail($id);
        $kpc->delete();
        return redirect()->route('insiden.kpc.index')->with('success', 'Data Insiden KPC berhasil dihapus');
    }
}
