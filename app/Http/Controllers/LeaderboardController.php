<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');

        $dates = $start && $end ? [$start, $end] : [date('Y-m-d'), date('Y-m-d')];

        $perawatQuery = User::whereHas('roles', fn($q) => $q->where('name', 'Perawat'))
            ->with(['aktivitasKeperawatan', 'refleksiHarian'])
            ->get();

        $data = $this->topPerawat($perawatQuery, $dates);

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $pagedData = $data->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $pagination = new LengthAwarePaginator(
            $pagedData,
            $data->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('leaderboard.index', [
            'topPerawat' => $pagination
        ]);
    }

    private function topPerawat($perawat, $dates)
    {
        return collect($perawat)->map(function ($user) use ($dates) {
            $avgAktivitas = $user->aktivitasKeperawatan()
                ->where('nilai', '>', 0)
                ->whereBetween('waktu', $dates)
                ->avg('nilai') ?? 0;

            $avgRefleksi = $user->refleksiHarian()
                ->where('nilai', '>', 0)
                ->whereBetween('waktu', $dates)
                ->avg('nilai') ?? 0;

            $nilai = collect([$avgAktivitas, $avgRefleksi])->filter();
            $score = $nilai->isNotEmpty() ? $nilai->avg() : 0;

            return [
                'user' => $user,
                'score' => round($score, 2)
            ];
        })->sortByDesc('score')->values();
    }

    public function export(Request $request)
    {
        if (!auth()->user()->can('leaderboard.export')) return abort(403);

        $start = $request->get('start');
        $end = $request->get('end');

        if ($start && $end) {
            $perawatQuery = User::whereHas('roles', fn($q) => $q->where('name', 'Perawat'))
            ->with(['aktivitasKeperawatan', 'refleksiHarian'])
            ->get();

            $data = $this->topPerawat($perawatQuery, [$start, $end]);

            $start_date = Carbon::parse($start)->locale('id')->translatedFormat('d F Y');
            $end_date = Carbon::parse($end)->locale('id')->translatedFormat('d F Y');

            // return view('leaderboard.export', compact('data'));

            $pdf = Pdf::loadView('leaderboard.export', compact('data'))->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ])->setPaper('a4', 'portrait');

            activity()
                ->event('Export Data')
                ->causedBy(auth()->user())
                ->withProperties(['ip' => request()->ip()])
                ->log('Mengexport Leaderboard Perawat');

            return $pdf->download('Leaderboard Kinerja Perawat - '.$start_date.' - '.$end_date.'.pdf');
        }
    }
}
