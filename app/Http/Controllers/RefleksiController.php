<?php

namespace App\Http\Controllers;

use App\Http\Requests\RefleksiRequest;
use App\Models\Refleksi;
use Illuminate\Http\Request;
use App\Services\RefleksiService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class RefleksiController extends Controller
{
    protected $service;

    public function __construct(RefleksiService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        if (!auth()->user()->can('refleksi.list')) return abort(403);

        $data = $this->service->listRefleksi($request);
        return view('refleksi.index', compact('data'));
    }

    public function create()
    {
        if (!auth()->user()->can('refleksi.buat')) return abort(403);

        return view('refleksi.create');
    }

    public function store(RefleksiRequest $request)
    {
        if (!auth()->user()->can('refleksi.buat')) return abort(403);

        $request->validated();
        $this->service->simpanRefleksi($request);
        return redirect()->route('refleksi.index')->with('success', 'Aktivitas berhasil disimpan');
    }

    public function show(Refleksi $refleksi_harian)
    {
        return view('refleksi.show', [
            'refleksi' => $refleksi_harian
        ]);
    }

    public function edit(Refleksi $refleksi_harian)
    {
        if (!auth()->user()->can('refleksi.edit')) return abort(403);

        return view('refleksi.edit', [
            'refleksi' => $refleksi_harian
        ]);
    }

    public function update(RefleksiRequest $request, Refleksi $refleksi_harian)
    {
        if (!auth()->user()->can('refleksi.edit')) return abort(403);

        $request->validated();
        $this->service->updateRefleksi($refleksi_harian, $request);
        return redirect()->route('refleksi.index')->with('success', 'Aktivitas berhasil diperbarui');
    }

    public function destroy(Refleksi $refleksi_harian)
    {
        if (!auth()->user()->can('refleksi.hapus')) return abort(403);

        $this->service->hapusRefleksi($refleksi_harian);
        return redirect()->route('refleksi.index')->with('success', 'Aktivitas berhasil dihapus');
    }

    public function updateApprovement(Request $request, Refleksi $refleksi_harian)
    {
        if (!auth()->user()->hasAnyPermission('refleksi.beri.approvement', 'refleksi.beri.nilai')) return abort(403);

        $request->validate([
            'approvement' => 'in:waiting,approved,rejected',
            'nilai' => 'nullable|numeric|min:0|max:100',
            'feedback' => 'nullable|string'
        ]);

        $this->service->updateApprovement($refleksi_harian, $request);

        if ($request->exists('nilai')) {
            $message = 'Nilai berhasil diperbarui';
        } else {
            $message = 'Status persetujuan berhasil diperbarui';
        }

        return redirect()->route('refleksi.show', $refleksi_harian->id)->with('success', $message);
    }

    public function export(Request $request)
    {
        if (!auth()->user()->can('refleksi.export')) return abort(403);

        $start = $request->get('start');
        $end = $request->get('end');

        if ($start && $end) {
            $data = Refleksi::
                select('waktu', 'jdl_kegiatan', 'user_id', 'approvement', 'nilai', 'feedback')
                ->with('user')
                ->whereDate('waktu', '>=' , $start)
                ->whereDate('waktu', '<=' , $end)
                ->latest()
                ->get();

            $start_date = Carbon::parse($start)->locale('id')->translatedFormat('d F Y');
            $end_date = Carbon::parse($end)->locale('id')->translatedFormat('d F Y');

            // return view('refleksi.export', compact('data'));
            $pdf = Pdf::loadView('refleksi.export', compact('data'))->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ])->setPaper('a4', 'landscape');

            activity()
                ->event('Export Data')
                ->causedBy(auth()->user())
                ->withProperties(['ip' => request()->ip()])
                ->log('Mengexport refleksi');

            return $pdf->download('Refleksi Harian - '.$start_date.' - '.$end_date.'.pdf');
        }
    }
}
