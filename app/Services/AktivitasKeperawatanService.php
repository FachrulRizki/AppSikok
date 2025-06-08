<?php

namespace App\Services;

use App\Models\AktivitasKeperawatan;
use App\Models\AktivitasKeperawatanLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AktivitasKeperawatanService
{
    public function listAktivitas($request)
    {
        $search = $request->get('search');
        $start = $request->get('start');
        $end = $request->get('end');

        $data = AktivitasKeperawatan::select(
            'id', 'waktu', 'shift', 'catatan', 'user_id', 'nilai'
        )->with(['user', 'logs']);

        if (auth()->user()->can('aktivitas_keperawatan.lihat.sendiri')) {
            $data = $data->where('user_id', auth()->user()->id);
        }

        if ($search) {
            $data = $data->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        if ($start && $end) {
            $data = $data->whereDate('waktu', '>=', $start)->whereDate('waktu', '<=', $end);
        }

        return $data->latest()->paginate(10);
    }

    public function simpanAktivitas(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $selectedActivities = json_decode($request->selectedActivities, true);
            $selectedDetails = json_decode($request->selectedDetails, true);
            $selectedTasks = json_decode($request->selectedTasks, true);
            $notes = json_decode($request->notes, true);

            $aktivitas = AktivitasKeperawatan::create([
                'waktu' => $request->waktu,
                'shift' => $request->shift,
                'catatan' => $request->catatan,
                'user_id' => auth()->user()->id,
            ]);

            foreach ($selectedDetails as $activityId => $detailIds) {
                foreach ($detailIds as $detailId) {
                    $tasks = $selectedTasks[$detailId] ?? [];

                    if (empty($tasks)) {
                        throw ValidationException::withMessages([
                            'aktivitas' => 'Ada detail aktivitas yang tidak memiliki kegiatan.',
                        ]);
                    }

                    foreach ($tasks as $taskId) {
                        AktivitasKeperawatanLog::create([
                            'aktivitas_keperawatan_id' => $aktivitas->id,
                            'activity_id' => $activityId,
                            'activity_detail_id' => $detailId,
                            'activity_task_id' => $taskId,
                            'catatan' => $notes[$detailId] ?? null,
                        ]);
                    }
                }
            }
        });
    }

    public function updateAktivitas(AktivitasKeperawatan $aktivitas_keperawatan, Request $request)
    {
        return DB::transaction(function () use ($request, $aktivitas_keperawatan) {
            $selectedDetails = json_decode($request->selectedDetails, true);
            $selectedTasks = json_decode($request->selectedTasks, true);
            $notes = json_decode($request->notes, true);

            $aktivitas_keperawatan->update([
                'waktu' => $request->waktu,
                'shift' => $request->shift,
                'catatan' => $request->catatan,
            ]);

            $aktivitas_keperawatan->logs()->delete();

            foreach ($selectedDetails as $activityId => $detailIds) {
                foreach ($detailIds as $detailId) {
                    $tasks = $selectedTasks[$detailId] ?? [];

                    if (empty($tasks)) {
                        throw ValidationException::withMessages([
                            'aktivitas' => 'Ada detail aktivitas yang tidak memiliki kegiatan.',
                        ]);
                    }

                    foreach ($tasks as $taskId) {
                        AktivitasKeperawatanLog::create([
                            'aktivitas_keperawatan_id' => $aktivitas_keperawatan->id,
                            'activity_id' => $activityId,
                            'activity_detail_id' => $detailId,
                            'activity_task_id' => $taskId,
                            'catatan' => $notes[$detailId] ?? null,
                        ]);
                    }
                }
            }
        });
    }

    public function hapusAktivitas(AktivitasKeperawatan $aktivitas)
    {
        return $aktivitas->delete();
    }

    public function updateNilai(AktivitasKeperawatan $aktivitas_keperawatan, Request $request)
    {
        $aktivitas_keperawatan->update($request->only('nilai'));
    }
}
