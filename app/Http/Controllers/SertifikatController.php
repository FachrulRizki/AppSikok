<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use Illuminate\Http\Request;

class SertifikatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search'); // untuk search berdasarkan nama sertifikat

        $sertifikat = Sertifikat::query();

        if ($search) {
            $sertifikat->where('nama_sertifikat', 'like', "%{$search}%");
        }

        $sertifikat = $sertifikat->paginate(10);

        return view('sertifikat.index', compact('sertifikat', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sertifikat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file_pdf' => 'required|mimes:pdf|max:2048',
        ]);

        $file = $request->file('file_pdf');
        $filename = time() . '-' . $file->getClientOriginalName();

        $file->storeAs('public/sertifikat', $filename);

        Sertifikat::create([
            'nama_file' => $filename,
            'nama_sertifikat' => $file->getClientOriginalName()
        ]);

        return redirect()->route('sertifikat.index')->with('status', 'Sertifikat berhasil diupload');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sertifikat $sertifikat)
    {
        return view('sertifikat.show', compact('sertifikat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sertifikat $unduh_sertifikat)
    {
        return view('sertifikat.edit', compact('sertifikat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sertifikat $unduh_sertifikat)
    {
        $request->validate([
            'file_pdf' => 'mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('file_pdf')) {
            // Hapus yang lama
            if ($unduh_sertifikat->nama_file && file_exists(storage_path('app/public/sertifikat/' . $unduh_sertifikat->nama_file))) {
                unlink(storage_path('app/public/sertifikat/' . $unduh_sertifikat->nama_file));
            }

            // Simpan yang baru
            $file = $request->file('file_pdf');
            $filename = time() . '-' . $file->getClientOriginalName();

            $file->storeAs('public/sertifikat', $filename);

            $unduh_sertifikat->update([
                'nama_file' => $filename,
                'nama_sertifikat' => $file->getClientOriginalName()
            ]);
        }

        return redirect()->route('sertifikat.index')->with('status', 'Sertifikat berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sertifikat $unduh_sertifikat)
    {
        if ($unduh_sertifikat->nama_file && file_exists(storage_path('app/public/sertifikat/' . $unduh_sertifikat->nama_file))) {
            unlink(storage_path('app/public/sertifikat/' . $unduh_sertifikat->nama_file));
        }

        $unduh_sertifikat->delete();

        return redirect()->route('sertifikat.index')->with('status', 'Sertifikat berhasil dihapus');
    }

    /**
     * Download the specified sertifikat.
     */
    public function download(Sertifikat $sertifikat)
    {
        $path = storage_path('app/public/sertifikat/' . $sertifikat->nama_file);

        if (file_exists($path)) {
            return response()->download($path, $sertifikat->nama_sertifikat);
        }

        abort(404, 'File tidak ditemukan.');
    }
}
