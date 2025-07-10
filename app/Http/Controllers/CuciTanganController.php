<?php

namespace App\Http\Controllers;

use App\Exports\CuciTanganExport;
use App\Models\CuciTangan;
use Illuminate\Http\Request;
use App\Services\CuciTanganService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class CuciTanganController extends Controller
{
    protected $service;

    public function __construct(CuciTanganService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        if (!auth()->user()->can('cuci_tangan.list')) return abort(403);

        $data = $this->service->getAll($request);

        return view('cuci_tangan.index', compact('data'));
    }

    public function create()
    {
        if (!auth()->user()->can('cuci_tangan.buat')) return abort(403);

        $activities = $this->service->getActivities();
        return view('cuci_tangan.create', compact('activities'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('cuci_tangan.buat')) return abort(403);

        $request->validate([
            'waktu' => 'required|date',
            'shift' => 'required|in:Pagi,Sore,Malam',
        ]);

        $this->service->store($request);

        return redirect()->route('cuci_tangan.index')->with('success', 'Data berhasil disimpan.');
    }

    public function show(CuciTangan $ppi)
    {
        $activities = $this->service->getActivities();
        return view('cuci_tangan.show', ['cuci_tangan' => $ppi, 'activities' => $activities]);
    }

    public function edit(CuciTangan $ppi)
    {
        if (!auth()->user()->can('cuci_tangan.edit')) return abort(403);

        $activities = $this->service->getActivities();

        $selectedDetails = is_string($ppi->details) ? json_decode($ppi->details, true) : ($ppi->details ?? []);
        $selectedTasks = is_string($ppi->tasks) ? json_decode($ppi->tasks, true) : ($ppi->tasks ?? []);
        $notes = is_string($ppi->notes) ? json_decode($ppi->notes, true) : ($ppi->notes ?? []);

        return view('cuci_tangan.edit', [
            'cuci_tangan' => $ppi,
            'activities' => $activities,
            'selectedDetails' => $selectedDetails,
            'selectedTasks' => $selectedTasks,
            'notes' => $notes,
        ]);
    }

    public function update(Request $request, CuciTangan $ppi)
    {
        if (!auth()->user()->can('cuci_tangan.edit')) return abort(403);

        $request->validate([
            'waktu' => 'required|date',
            'shift' => 'required|in:Pagi,Sore,Malam',
            'details' => 'nullable|array',
            'tasks' => 'nullable|array',
            'notes' => 'nullable|array',
        ]);

        $this->service->update($ppi, $request);

        return redirect()->route('cuci_tangan.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(CuciTangan $ppi)
    {
        if (!auth()->user()->can('cuci_tangan.hapus')) return abort(403);

        $this->service->delete($ppi);

        return redirect()->route('cuci_tangan.index')->with('success', 'Data berhasil dihapus.');
    }

    public function export(Request $request)
    {
        if (!auth()->user()->can('cuci_tangan.export')) return abort(403);

        $start = $request->get('start');
        $end = $request->get('end');

        if ($start && $end) {
            $activities = collect($this->service->getActivities());
            $records = CuciTangan::
                select('waktu', 'user_id', 'shift', 'details', 'tasks', 'notes')
                ->with('user')
                ->whereDate('waktu', '>=' , $start)
                ->whereDate('waktu', '<=' , $end)
                ->latest()
                ->get();
            
            $data = [];

            foreach ($records as $record) {
                $details = json_decode($record->details, true);
                $tasks = json_decode($record->tasks, true);
                $notes = json_decode($record->notes, true);

                $row = [
                    'user_name' => $record->user->name,
                    'user_unit' => $record->user->unit,
                    'shift' => $record->shift,
                    'waktu' => $record->waktu,
                    'data' => [] 
                ];

                foreach ($activities as $activity) {
                    $activityRows = [];
                    $activityDetails = $detailsByActivity[$activity['id']] ?? [];
                    $activityTasks = $tasksByDetail ?? [];

                    $details = is_array($details) ? $details : [];

                    foreach ($activity['details'] as $detail) {
                        $hasDetail = in_array($detail['id'], $details);
                        $hasTask = isset($tasks[$detail['id']]) && is_array($tasks[$detail['id']]) && count($tasks[$detail['id']]) > 0;

                        if ($hasDetail || $hasTask) {
                            $detailTasks = [];

                            foreach ($detail['tasks'] ?? [] as $task) {
                                if (in_array($task['id'], $tasks[$detail['id']] ?? [])) {
                                    $detailTasks[] = $task['nama'];
                                }
                            }

                            $activityRows[] = [
                                'detail' => $detail['nama'],
                                'tasks' => $detailTasks
                            ];
                        }
                    }

                    if (count($activityRows)) {
                        $row['data'][] = [
                            'nama' => $activity['nama'],
                            'catatan' => $notes[$activity['id']] ?? '-',
                            'rows' => $activityRows
                        ];
                    }
                }

                $data[] = $row;
            }

            $start_date = Carbon::parse($start)->locale('id')->translatedFormat('d F Y');
            $end_date = Carbon::parse($end)->locale('id')->translatedFormat('d F Y');

            // return view('cuci_tangan.export', compact('data'));

            return Excel::download(new CuciTanganExport($data), 'Cuci Tangan - '.$start_date.' - '.$end_date.'.xlsx');
        }
    }
}
