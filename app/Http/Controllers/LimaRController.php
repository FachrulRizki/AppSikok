<?php

namespace App\Http\Controllers;

use App\Models\LimaR;
use App\Services\LimaRService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LimaRController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('lima_r.list')) return abort(403);
        
        $search = $request->get('search');

        $data = LimaR::query();

        if (auth()->user()->can('lima_r.lihat.sendiri')) {
            $data = $data->where('user_id', auth()->user()->id);
        }

        if ($search) {
            $data->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        $data = $data->latest()->paginate(10);

        return view('lima_r.index', compact('data'));
    }

    public function create()
    {
        if (!auth()->user()->can('lima_r.buat')) return abort(403);

        return view('lima_r.create', [
            'route' => route('lima_r.store'),
            'method' => 'POST'
        ]);
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('lima_r.buat')) return abort(403);

        $validated = $request->validate([
            'waktu' => 'required|date',
            'shift' => 'required|string',
            'dilaksanakan' => 'required|array|size:5',
            'catatan' => 'nullable|array|size:5',
            'foto.*' => 'nullable|image|max:102400|mimetypes:image/jpeg,image/png',
        ]);

        // Simpan foto
        $fotoPaths = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $path = $file->store('foto_lima_r', 'public');
                $fotoPaths[] = $path;
            }
        }

        LimaR::create([
            'waktu' => $validated['waktu'],
            'shift' => $validated['shift'],
            'dilaksanakan' => json_encode($validated['dilaksanakan']),
            'catatan' => json_encode($validated['catatan']),
            'foto' => $fotoPaths,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('lima_r.index')->with('success', 'Data 5R berhasil disimpan.');
    }

    public function show($id)
    {
        $lima_r = LimaR::findOrFail($id);
        return view('lima_r.show', compact('lima_r'));
    }

    public function destroy(LimaR $LimaR)
    {
        if (!auth()->user()->can('lima_r.hapus')) return abort(403);

        if ($LimaR->foto) {
            foreach ($LimaR->foto as $foto) {
                Storage::disk('public')->delete($foto);
            }
        }

        $LimaR->delete();
        return redirect()->route('lima_r.index')->with('success', 'Data 5R berhasil dihapus.');
    }
}
