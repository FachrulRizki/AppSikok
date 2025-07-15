<?php

namespace App\Http\Controllers;

use App\Models\LimaR;
use App\Services\ImageCompressorService;
use App\Services\LimaRService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LimaRController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('lima_r.list')) return abort(403);
        
        $search = $request->get('search');
        $start = $request->get('start');
        $end = $request->get('end');

        $data = LimaR::query();

        if (auth()->user()->can('lima_r.lihat.sendiri')) {
            $data = $data->where('user_id', auth()->user()->id);
        }

        if ($search) {
            $data->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        if ($start && $end) {
            $data = $data->whereDate('waktu', '>=', $start)->whereDate('waktu', '<=', $end);
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

    public function store(Request $request, ImageCompressorService $compressor)
    {
        if (!auth()->user()->can('lima_r.buat')) return abort(403);

        $validated = $request->validate([
            'waktu' => 'required|date',
            'shift' => 'required|string',
            'dilaksanakan' => 'required|array|size:5',
            'catatan' => 'nullable|array|size:5',
            'foto' => 'nullable|array|max:5',
            'foto.*' => 'image|max:2048|mimetypes:image/jpeg,image/png,image/webp',
        ]);

        // Simpan foto
        $fotoPaths = [];
        if ($request->hasFile('foto')) {
            $fotoPaths = $compressor->compressAndUpload($request->file('foto'), 'foto_lima_r');
        }

        LimaR::create([
            'waktu' => $validated['waktu'],
            'shift' => $validated['shift'],
            'dilaksanakan' => json_encode($validated['dilaksanakan']),
            'catatan' => json_encode($validated['catatan']),
            'foto' => $fotoPaths,
            'user_id' => auth()->id(),
        ]);

        activity()
            ->event('Buat Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Membuat Data 5R');

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

        activity()
            ->event('Hapus Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Menghapus Data 5R');

        return redirect()->route('lima_r.index')->with('success', 'Data 5R berhasil dihapus.');
    }

    public function export(Request $request)
    {
        if (!auth()->user()->can('lima_r.export')) return abort(403);

        $start = $request->get('start');
        $end = $request->get('end');

        if ($start && $end) {
            $data = LimaR::
                select('waktu', 'user_id', 'shift', 'dilaksanakan', 'foto', 'catatan')
                ->with('user')
                ->whereDate('waktu', '>=' , $start)
                ->whereDate('waktu', '<=' , $end)
                ->latest()
                ->get();

            $start_date = Carbon::parse($start)->locale('id')->translatedFormat('d F Y');
            $end_date = Carbon::parse($end)->locale('id')->translatedFormat('d F Y');

            foreach ($data as $item) {
                $gambar_base64 = [];

                $gambarArray = $item->foto;

                if (is_array($gambarArray)) {
                    foreach ($gambarArray as $namaFile) {
                        $path = public_path('storage/' . $namaFile);
                        if (file_exists($path)) {
                            $ext = pathinfo($path, PATHINFO_EXTENSION);
                            $content = file_get_contents($path);
                            $gambar_base64[] = 'data:image/' . $ext . ';base64,' . base64_encode($content);
                        }
                    }
                }

                $item->setAttribute('gambar_base64', $gambar_base64);
            }

            // return view('lima_r.export', compact('data', 'start_date', 'end_date'));

            $pdf = Pdf::loadView('lima_r.export', compact('data', 'start_date', 'end_date'))->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ])->setPaper('a4', 'portrait');

            activity()
                ->event('Export Data')
                ->causedBy(auth()->user())
                ->withProperties(['ip' => request()->ip()])
                ->log('Mengexport Data 5R');

            return $pdf->download('Laporan 5R - '.$start_date.' - '.$end_date.'.pdf');
        }
    }
}
