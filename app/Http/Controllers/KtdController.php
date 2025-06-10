<?php

namespace App\Http\Controllers;

use App\Services\KtdService;
use App\Models\Ktd;
use Illuminate\Http\Request;

class KtdController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('insiden.list')) return abort(403);

        $ktds = Ktd::latest()->paginate(10);

        return view('datamutu.insiden.ktd.index', compact('ktds'));
    }

    public function create()
    {
        if (!auth()->user()->can('insiden.buat')) return abort(403);

        return view('datamutu.insiden.ktd.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('insiden.buat')) return abort(403);

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
                $path = $file->store('foto_ktd', 'public');
                $fotoPaths[] = $path;
            }
        }

        Ktd::create([
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

        return redirect()->route('insiden.ktd.index')->with('success', 'Data Laporan KTD berhasil disimpan.');
    }

    public function show($id)
    {
        $ktd = ktd::findOrFail($id);
        return view('datamutu.insiden.ktd.show', compact('ktd'));
    }

    public function destroy(Ktd $ktd)
    {
        if (!auth()->user()->can('insiden.hapus')) return abort(403);

        $ktd->delete();
        return redirect()->route('insiden.ktd.index')->with('success', 'Data Laporan KTD berhasil dihapus.');
    }
}
