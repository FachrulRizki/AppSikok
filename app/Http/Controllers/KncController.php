<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Knc;

class KncController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('insiden.list')) return abort(403);

        $kncs = Knc::latest()->paginate(10);
        
        return view('datamutu.insiden.knc.index', compact('kncs'));
    }

    public function create()
    {
        if (!auth()->user()->can('insiden.buat')) return abort(403);

        return view('datamutu.insiden.knc.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('insiden.buat')) return abort(403);

        $validated = $request->validate([
            'no_rm' => 'required|string|max:100',
            'nama_pasien' => 'required|string|max:255',
            'umur' => 'required|string|max:50',
            'jk' => 'required|in:Laki-Laki,Perempuan',
            'waktu_mskrs' => 'nullable|date',
            'waktu_insiden' => 'nullable|date',
            'temuan' => 'required|string',
            'kronologis' => 'required|string',
            'tindakan_segera' => 'required|string', 
            'insiden_pada' => 'required|string|max:255',
            'unit_terkait' => 'required|string|max:255',
            'sumber' => 'required|string',
            'rawat' => 'required|string',
            'poli' => 'required|string',
            'pelaksana' => 'required|string',
            'nama_inisial' => 'required|string',
            'ruangan_pelapor' => 'required|string',
            'foto.*' => 'nullable|image|max:102400|mimetypes:image/jpeg,image/png',
        ]);

        $fotoPaths = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $path = $file->store('foto_knc', 'public');
                $fotoPaths[] = $path;
            }
        }

        Knc::create([
            'no_rm' => $validated['no_rm'],
            'nama_pasien' => $validated['nama_pasien'],
            'umur' => $validated['umur'],
            'jk' => $validated['jk'],
            'waktu_mskrs' => $validated['waktu_mskrs'] ?? null,
            'waktu_insiden' => $validated['waktu_insiden'] ?? null,
            'temuan' => $validated['temuan'],
            'kronologis' => $validated['kronologis'],
            'tindakan_segera' => $validated['tindakan_segera'],
            'insiden_pada' => $validated['insiden_pada'],
            'unit_terkait' => $validated['unit_terkait'],
            'sumber' => $validated['sumber'],
            'rawat' => $validated['rawat'],
            'poli' => $validated['poli'],
            'pelaksana' => $validated['pelaksana'],
            'nama_inisial' => $validated['nama_inisial'],
            'ruangan_pelapor' => $validated['ruangan_pelapor'],
            'foto' => $fotoPaths
        ]);

        return redirect()->route('insiden.knc.index')->with('success', 'Data Laporan KNC berhasil disimpan.');
    }

    public function show($id)
    {
        $knc = knc::findOrFail($id);
        
        return view('datamutu.insiden.knc.show', compact('knc'));
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('insiden.hapus')) return abort(403);

        $knc = knc::findOrFail($id);
        $knc->delete();
        return redirect()->route('insiden.knc.index')->with('success', 'Data Laporan KNC berhasil dihapus.');
    }
}
