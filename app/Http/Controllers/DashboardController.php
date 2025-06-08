<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $perawat = User::whereHas('roles', fn ($q) => $q->where('name', 'perawat'))
            ->with(['aktivitasKeperawatan', 'refleksiHarian'])
            ->get();

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
        
        $avgPersenAktivitas = round($perawat->avg(fn($u) => $u->aktivitasKeperawatan->where('nilai', '>', 0)->avg('nilai') ?? 0), 2);
        $avgPersenRefleksi  = round($perawat->avg(fn($u) => $u->refleksiHarian->where('nilai', '>', 0)->avg('nilai') ?? 0), 2);

        return view('dashboard', compact('topPerawat', 'avgPersenAktivitas', 'avgPersenRefleksi'));
    }
}
