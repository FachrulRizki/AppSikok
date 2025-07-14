<?php

namespace App\Http\Controllers;

use App\Exports\KuesionerExport;
use Illuminate\Http\Request;
use App\Models\KuisonerKepuasan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class KuisonerKepuasanController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('kuesioner.list')) return abort(403);

        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');
        $ruangan = $request->get('ruangan');

        $data = KuisonerKepuasan::query();

        if ($bulan && $tahun) {
            $data = $data->whereMonth('waktu_survei', $bulan)->whereYear('waktu_survei', $tahun);
        }

        if ($ruangan) {
            $data = $data->where('ruangan', $ruangan);
        }

        $data = $data->latest()->paginate(10);

        $availablePeriods = DB::table('kuisoner_kepuasan')
            ->selectRaw('MONTH(waktu_survei) as bulan, YEAR(waktu_survei) as tahun, ruangan')
            ->groupBy('tahun', 'bulan', 'ruangan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();

        return view('kuisoner.index', compact('data', 'availablePeriods'));
    }

    public function create()
    {
        if (!auth()->user()->can('kuesioner.buat')) return abort(403);

        return view('kuisoner.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('kuesioner.buat')) return abort(403);

        $request->validate([
            'waktu_survei' => 'required|date',
            'jk' => 'required',
            'usia' => 'required|integer',
            'pendidikan' => 'required',
            'pekerjaan' => 'required',
            'hubungan_pasien' => 'required',
            'p1' => 'required',
            'p2' => 'required',
            'p3' => 'required',
            'p4' => 'required',
            'p5' => 'required',
            'p6' => 'required',
            'p7' => 'required',
            'p8' => 'required',
            'p9' => 'required',
            'saran' => 'required|string',
            'tingkat_kepuasan' => 'required|string',
            'ruangan' => 'required|string',
        ]);

        $data = KuisonerKepuasan::create($request->all());

        return redirect()->route('kuesioner.show', $data->id)->with('success', 'Terima kasih atas partisipasi Anda!');
    }

    public function show($id)
    {
        $kuesioner = KuisonerKepuasan::findOrFail($id);
        return view('kuisoner.show', compact('kuesioner'));
    }


    public function destroy($id)
    {
        if (!auth()->user()->can('kuesioner.hapus')) return abort(403);

        $data = KuisonerKepuasan::findOrFail($id);
        $data->delete();

        return redirect()->route('kuesioner.index')->with('success', 'Kuesioner berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');
        $ruangan = $request->get('ruangan');

        $data = KuisonerKepuasan::query();

        if ($bulan && $tahun) {
            $data = $data->whereMonth('waktu_survei', $bulan)->whereYear('waktu_survei', $tahun);   
        }

        if ($ruangan) {
            $data = $data->where('ruangan', $ruangan);
        }

        $data = $data->latest()->get();

        $jumlahPerUnsur = array_fill(1, 9, 0);
        $totalData = $data->count();

        foreach ($data as $item) {
            for ($i = 1; $i <= 9; $i++) {
                $jumlahPerUnsur[$i] += $item["p$i"];
            }
        }

        $nrrTertimbang = [];
        for ($i = 1; $i <= 9; $i++) {
            $rata = $totalData > 0 ? $jumlahPerUnsur[$i] / $totalData : 0;
            $nrrTertimbang[$i] = round($rata * 0.11, 2);
        }

        $ikm = round(array_sum($nrrTertimbang) * 25, 2);

        // return view('kuisoner.export', compact(
        //     'data',
        //     'jumlahPerUnsur',
        //     'nrrTertimbang',
        //     'ikm',
        //     'bulan',
        //     'tahun'
        // ));

        return Excel::download(new KuesionerExport($data, $jumlahPerUnsur, $nrrTertimbang, $ikm, $bulan, $tahun), 'Laporan Kuesioner-'.$bulan.'-'.$tahun.'-'. ($ruangan ?? 'Semua Ruangan').'.xlsx');
    }
}
