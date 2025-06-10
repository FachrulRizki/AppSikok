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
    public function index()
    {
        $perawat = User::whereHas('roles', fn($q) => $q->where('name', 'perawat'))
            ->with(['aktivitasKeperawatan', 'refleksiHarian'])
            ->get();

        // Leaderboard Perawat
        $topPerawat = $perawat
            ->map(function ($user) {
                $avgAktivitas = $user->aktivitasKeperawatan->where('nilai', '>', 0)->avg('nilai') ?? 0;
                $avgRefleksi = $user->refleksiHarian->where('nilai', '>', 0)->avg('nilai') ?? 0;

                $nilai = collect([$avgAktivitas, $avgRefleksi])->filter();
                $score = $nilai->isNotEmpty() ? $nilai->avg() : 0;

                return [
                    'user' => $user,
                    'score' => $score,
                    'avgAktivitas' => round($avgAktivitas, 2),
                    'avgRefleksi' => round($avgRefleksi, 2),
                ];
            })
            ->sortByDesc('score')
            ->take(5);

        // Rata-rata persentase aktivitas dan refleksi
        $avgPersenAktivitas = round($perawat->avg(fn($u) => $u->aktivitasKeperawatan->where('nilai', '>', 0)->avg('nilai') ?? 0), 2);
        $avgPersenRefleksi  = round($perawat->avg(fn($u) => $u->refleksiHarian->where('nilai', '>', 0)->avg('nilai') ?? 0), 2);

        // Chart Insiden
        $kncCount = Knc::count();
        $ktcCount = Ktc::count();
        $ktdCount = Ktd::count();
        $kpcCount = Kpc::count();
        $sentinelCount = Sentinel::count();

        $chartInsidenData = [
            'labels' => ['KNC', 'KTC', 'KTD', 'KPC', 'Sentinel'],
            'data' => [$kncCount, $ktcCount, $ktdCount, $kpcCount, $sentinelCount],
        ];

        // Chart kepuasan pasien
        $kepuasanPelanggan = $this->chartIKMHarian();

        return view('dashboard', compact(
            'topPerawat',
            'avgPersenAktivitas',
            'avgPersenRefleksi',
            'chartInsidenData',
            'kepuasanPelanggan'
        ));
    }

    private function chartIKMHarian()
    {
        $today = Carbon::today();

        $kuisionerHariIni = KuisonerKepuasan::whereDate('waktu_survei', $today)->get();
        $jumlah = $kuisionerHariIni->count();

        $nrr = [];
        $nrrTertimbang = [];

        for ($i = 1; $i <= 9; $i++) {
            $totalNilai = $kuisionerHariIni->sum("p$i");

            if ($jumlah != 0) {
                $nilaiRata = $totalNilai / $jumlah;
            } else {
                $nilaiRata = 0; // atau null tergantung kebutuhan
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
