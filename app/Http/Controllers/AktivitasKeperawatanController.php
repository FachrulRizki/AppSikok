<?php

namespace App\Http\Controllers;

use App\Http\Requests\AktivitasKeperawatanRequest;
use App\Models\Activity;
use App\Models\ActivityDetail;
use App\Models\ActivityTask;
use Illuminate\Http\Request;
use App\Models\AktivitasKeperawatan;
use Illuminate\Support\Facades\Auth;
use App\Services\AktivitasKeperawatanService;
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

        $activities = Activity::with('activity_details.activity_tasks')->get();

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
        if (!auth()->user()->can('aktivitas_keperawatan.beri.nilai')) return abort(403);

        $request->validate([
            'nilai' => 'nullable|numeric|min:0|max:100',
        ]);

        $this->service->updateNilai($aktivitas_keperawatan, $request);

        return redirect()->route('aktivitas_keperawatan.show', $aktivitas_keperawatan->id)->with('success', 'Nilai berhasil diperbarui');
    }
}

