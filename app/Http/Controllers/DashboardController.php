<?php

namespace App\Http\Controllers;

use App\Models\Knc;
use App\Models\Kpc;
use App\Models\Ktc;
use App\Models\Ktd;
use App\Models\KuisonerKepuasan;
use App\Models\Sentinel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');
        $ruangan = $request->get('ruangan');

        $dates = [];
        if ($start && $end) {
            $dates = [$start, $end];
        } else {
            $dates = [date('Y-m-d'), date('Y-m-d')];
        }

        $perawat = User::whereHas('roles', fn($q) => $q->where('name', 'perawat'))
            ->with(['aktivitasKeperawatan', 'refleksiHarian'])
            ->get();

        return view('dashboard', [
            'topPerawat' => $this->topPerawat($perawat, $dates),
            'avgPersenAktivitas' => $this->capaian($perawat, $dates)[0],
            'avgPersenRefleksi' => $this->capaian($perawat, $dates)[1],
            'chartInsidenData' => $this->chartInsiden($dates, $ruangan),
            'kepuasanPelanggan' => $this->chartIKMHarian($dates, $ruangan)
        ]);
    }

    private function capaian($perawat, $dates)
    {
        $avgPersenAktivitas = round($perawat->avg(fn($u) => $u->aktivitasKeperawatan()->
            where('nilai', '>', 0)->
            whereDate('waktu', '>=', $dates[0])->whereDate('waktu', '<=', $dates[1])->
            avg('nilai') ?? 0), 2);
        $avgPersenRefleksi  = round($perawat->avg(fn($u) => $u->refleksiHarian()->
            where('nilai', '>', 0)->
            whereDate('waktu', '>=', $dates[0])->whereDate('waktu', '<=', $dates[1])->
            avg('nilai') ?? 0), 2);

        return [$avgPersenAktivitas, $avgPersenRefleksi];
    }

    private function chartInsiden($dates, $ruangan)
    {
        $kncCount = Knc::whereDate('waktu_insiden', '>=', $dates[0])->whereDate('waktu_insiden', '<=', $dates[1]);
        $ktcCount = Ktc::whereDate('waktu_insiden', '>=', $dates[0])->whereDate('waktu_insiden', '<=', $dates[1]);
        $ktdCount = Ktd::whereDate('waktu_insiden', '>=', $dates[0])->whereDate('waktu_insiden', '<=', $dates[1]);
        $kpcCount = Kpc::whereDate('waktu', '>=', $dates[0])->whereDate('waktu', '<=', $dates[1]);
        $sentinelCount = Sentinel::whereDate('waktu_insiden', '>=', $dates[0])->whereDate('waktu_insiden', '<=', $dates[1]);

        if ($ruangan) {
            $kncCount = $kncCount->where('ruangan_pelapor', $ruangan);
            $ktcCount = $ktcCount->where('ruangan_pelapor', $ruangan);
            $ktdCount = $ktdCount->where('ruangan_pelapor', $ruangan);
            $kpcCount = $kpcCount->where('ruangan', $ruangan);
            $sentinelCount = $sentinelCount->where('ruangan_pelapor', $ruangan);
        }

        return [
            'labels' => ['KNC', 'KTC', 'KTD', 'KPC', 'Sentinel'],
            'data' => [$kncCount->count(), $ktcCount->count(), $ktdCount->count(), $kpcCount->count(), $sentinelCount->count()],
        ];
    }

    private function topPerawat($perawat, $dates)
    {
        return $perawat
            ->map(function ($user) use ($dates) {
                $avgAktivitas = $user->aktivitasKeperawatan()->
                    where('nilai', '>', 0)->
                    whereDate('waktu', '>=', $dates[0])->whereDate('waktu', '<=', $dates[1])->
                    avg('nilai') ?? 0;
                $avgRefleksi = $user->refleksiHarian()->
                    where('nilai', '>', 0)->
                    whereDate('waktu', '>=', $dates[0])->whereDate('waktu', '<=', $dates[1])->
                    avg('nilai') ?? 0;

                $nilai = collect([$avgAktivitas, $avgRefleksi])->filter();
                $score = $nilai->isNotEmpty() ? $nilai->avg() : 0;

                return [
                    'user' => $user,
                    'score' => round($score, 2),
                    'avgAktivitas' => round($avgAktivitas, 2),
                    'avgRefleksi' => round($avgRefleksi, 2),
                ];
            })
            ->sortByDesc('score')
            ->take(5);
    }

    private function chartIKMHarian($dates, $ruangan)
    {
        $kuisionerHariIni = KuisonerKepuasan::
            whereDate('waktu_survei', '>=', $dates[0])->
            whereDate('waktu_survei', '<=', $dates[1])->
            get();
        
        if ($ruangan) {
            $kuisionerHariIni = $kuisionerHariIni->where('ruangan', $ruangan);
        }

        $jumlah = $kuisionerHariIni->count();

        $nrr = [];
        $nrrTertimbang = [];

        for ($i = 1; $i <= 9; $i++) {
            $totalNilai = $kuisionerHariIni->sum("p$i");

            if ($jumlah != 0) {
                $nilaiRata = $totalNilai / $jumlah;
            } else {
                $nilaiRata = 0;
            }

            $nrr[] = round($nilaiRata, 2);
            $nrrTertimbang[] = round($nilaiRata * 0.11, 2);
        }


        $ikm = round(array_sum($nrrTertimbang) * 25, 2);

        return [
            'series' => $nrrTertimbang,
            'categories' => ['U1', 'U2', 'U3', 'U4', 'U5', 'U6', 'U7', 'U8', 'U9'],
            'ikm' => $ikm
        ];
    }
}
