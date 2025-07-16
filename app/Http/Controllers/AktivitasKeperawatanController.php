<?php

namespace App\Http\Controllers;

use App\Http\Requests\AktivitasKeperawatanRequest;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\AktivitasKeperawatan;
use App\Services\AktivitasKeperawatanService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class AktivitasKeperawatanController extends Controller
{
    protected $service;

    public function __construct(AktivitasKeperawatanService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        if (!auth()->user()->can('aktivitas_keperawatan.list')) return abort(403);

        $data = $this->service->listAktivitas($request);
        return view('aktivitas_keperawatan.index', compact('data'));
    }

    public function create()
    {
        if (!auth()->user()->can('aktivitas_keperawatan.buat')) return abort(403);

        $route = route('aktivitas_keperawatan.store');
        $method = 'POST';
        $activities = Activity::with('activity_details.activity_tasks')->orderByRaw('CAST(kode AS UNSIGNED) ASC')->get();
        return view('aktivitas_keperawatan.create', compact('route', 'method', 'activities'));
    }

    public function store(AktivitasKeperawatanRequest $request)
    {
        if (!auth()->user()->can('aktivitas_keperawatan.buat')) return abort(403);

        $request->validated();

        try {
            $this->service->simpanAktivitas($request);

            activity()
                ->event('Buat Data')
                ->causedBy(auth()->user())
                ->withProperties(['ip' => request()->ip()])
                ->log('Membuat aktivitas keperawatan');

            return redirect()->route('aktivitas_keperawatan.index')->with('success', 'Aktivitas Keperawatan berhasil diperbarui');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }

    public function show(AktivitasKeperawatan $aktivitas_keperawatan)
    {
        $aktivitas_keperawatan->load('logs.activity', 'logs.activity_detail', 'logs.activity_task', 'user');
        
        return view('aktivitas_keperawatan.show', compact('aktivitas_keperawatan'));
    }

    public function edit(AktivitasKeperawatan $aktivitas_keperawatan)
    {
        if (!auth()->user()->can('aktivitas_keperawatan.edit')) return abort(403);

        $activities = Activity::with('activity_details.activity_tasks')->orderByRaw('CAST(kode AS UNSIGNED) ASC')->get();

        $logs = $aktivitas_keperawatan->logs()->get();

        $details = [];
        $tasks = [];
        $notes = [];

        foreach ($logs as $log) {
            if (!isset($details[$log->activity_id])) {
                $details[$log->activity_id] = [];
            }
            if (!in_array($log->activity_detail_id, $details[$log->activity_id])) {
                $details[$log->activity_id][] = $log->activity_detail_id;
            }

            if (!isset($tasks[$log->activity_detail_id])) {
                $tasks[$log->activity_detail_id] = [];
            }
            if (!in_array($log->activity_task_id, $tasks[$log->activity_detail_id])) {
                $tasks[$log->activity_detail_id][] = $log->activity_task_id;
            }

            if ($log->catatan) {
                $notes[$log->activity_detail_id] = $log->catatan;
            }
        }

        return view('aktivitas_keperawatan.edit', compact(
            'aktivitas_keperawatan', 
            'activities',
            'details',
            'tasks',
            'notes'
        ));
    }

    public function update(AktivitasKeperawatanRequest $request, AktivitasKeperawatan $aktivitas_keperawatan)
    {
        if (!auth()->user()->can('aktivitas_keperawatan.edit')) return abort(403);

        $request->validated();

        try {
            $this->service->updateAktivitas($aktivitas_keperawatan, $request);

            activity()
                ->event('Update Data')
                ->causedBy(auth()->user())
                ->withProperties(['ip' => request()->ip()])
                ->log('Mengupdate aktivitas keperawatan');

            return redirect()->route('aktivitas_keperawatan.index')->with('success', 'Aktivitas Keperawatan berhasil diperbarui');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        }
    }

    public function destroy(AktivitasKeperawatan $aktivitas_keperawatan)
    {
        if (!auth()->user()->can('aktivitas_keperawatan.hapus')) return abort(403);

        $this->service->hapusAktivitas($aktivitas_keperawatan);

        return redirect()->route('aktivitas_keperawatan.index')->with('success', 'Data berhasil dihapus');
    }

    public function updateNilai(Request $request, AktivitasKeperawatan $aktivitas_keperawatan)
    {
        if (!auth()->user()->hasAnyPermission('aktivitas_keperawatan.beri.nilai', 'aktivitas_keperawatan.beri.approvement')) return abort(403);

        $request->validate([
            'nilai' => 'nullable|numeric|min:0|max:100',
            'approvement' => 'in:waiting,approved,rejected',
            'feedback' => 'nullable|string'
        ]);

        $this->service->updateNilai($aktivitas_keperawatan, $request);

        if ($request->exists('nilai')) {
            $message = 'Nilai berhasil diperbarui';
        } else {
            $message = 'Status persetujuan berhasil diperbarui';
        }

        return redirect()->route('aktivitas_keperawatan.show', $aktivitas_keperawatan->id)->with('success', $message);
    }

    public function export(Request $request)
    {
        if (!auth()->user()->can('aktivitas_keperawatan.export')) return abort(403);

        $start = $request->get('start');
        $end = $request->get('end');

        if ($start && $end) {
            $data = AktivitasKeperawatan::
                whereDate('waktu', '>=' , $start)
                ->whereDate('waktu', '<=' , $end)
                ->latest()
                ->get();

            $start_date = Carbon::parse($start)->locale('id')->translatedFormat('d F Y');
            $end_date = Carbon::parse($end)->locale('id')->translatedFormat('d F Y');

            // return view('aktivitas_keperawatan.export', compact('data'));
            $pdf = Pdf::loadView('aktivitas_keperawatan.export', compact('data'))->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

            activity()
                ->event('Export Data')
                ->causedBy(auth()->user())
                ->withProperties(['ip' => request()->ip()])
                ->log('Mengexport aktivitas keperawatan');

            return $pdf->download('Aktivitas Keperawatan - '.$start_date.' - '.$end_date.'.pdf');
        }
    }
}

