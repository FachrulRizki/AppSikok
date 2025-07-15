<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use Illuminate\Http\Request;

class SertifikatController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('unduh_sertifikat.list')) return abort(403);

        $search = $request->input('search');

        $data = Sertifikat::query();

        if ($search) {
            $data->where('nama_sertifikat', 'like', "%{$search}%");
        }

        $data = $data->latest()->paginate(10);

        return view('sertifikat.index', compact('data'));
    }

    public function create()
    {
        if (!auth()->user()->can('unduh_sertifikat.buat')) return abort(403);

        return view('sertifikat.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('unduh_sertifikat.buat')) return abort(403);

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

        activity()
            ->event('Buat Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Mengupload Sertifikat');

        return redirect()->route('sertifikat.index')->with('status', 'Sertifikat berhasil diupload');
    }

    public function edit(Sertifikat $unduh_sertifikat)
    {
        if (!auth()->user()->can('unduh_sertifikat.edit')) return abort(403);

        return view('sertifikat.edit', [
            'sertifikat' => $unduh_sertifikat
        ]);
    }

    public function update(Request $request, Sertifikat $unduh_sertifikat)
    {
        if (!auth()->user()->can('unduh_sertifikat.edit')) return abort(403);

        $request->validate([
            'file_pdf' => 'required|mimes:pdf|max:2048',
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

        activity()
            ->event('Update Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Mengupdate Sertifikat');

        return redirect()->route('sertifikat.index')->with('status', 'Sertifikat berhasil diupdate');
    }

    public function destroy(Sertifikat $unduh_sertifikat)
    {
        if (!auth()->user()->can('unduh_sertifikat.hapus')) return abort(403);

        if ($unduh_sertifikat->nama_file && file_exists(storage_path('app/public/sertifikat/' . $unduh_sertifikat->nama_file))) {
            unlink(storage_path('app/public/sertifikat/' . $unduh_sertifikat->nama_file));
        }

        $unduh_sertifikat->delete();

        activity()
            ->event('Hapus Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Menghapus Sertifikat');

        return redirect()->route('sertifikat.index')->with('status', 'Sertifikat berhasil dihapus');
    }

    public function download(Sertifikat $sertifikat)
    {
        if (!auth()->user()->can('unduh_sertifikat.download')) return abort(403);

        $path = storage_path('app/public/sertifikat/' . $sertifikat->nama_file);

        if (file_exists($path)) {
            activity()
                ->event('Download')
                ->causedBy(auth()->user())
                ->withProperties(['ip' => request()->ip()])
                ->log('Mendownload Sertifikat');

            return response()->download($path, $sertifikat->nama_sertifikat);
        }

        abort(404, 'File tidak ditemukan.');
    }
}
