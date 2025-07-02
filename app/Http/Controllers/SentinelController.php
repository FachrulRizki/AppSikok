<?php

namespace App\Http\Controllers;

use App\Exports\SentinelExport;
use App\Services\SentinelService;
use App\Models\Sentinel;
use App\Services\ImageCompressorService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SentinelController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('insiden.list')) return abort(403);

        $triwulan = $request->get('triwulan');
        $tahun = $request->get('tahun');

        $data = Sentinel::query();

        if ($triwulan && $tahun) {
            $awal = Carbon::create($tahun, $triwulan * 3 - 2, 1);
            $akhir = Carbon::create($tahun, $triwulan * 3, 30)->endOfMonth();
            $data = $data->whereDate('waktu_insiden', '>=' , $awal)->whereDate('waktu_insiden', '<=' , $akhir);
        }

        $data = $data->latest()->paginate(10);

        $availablePeriods = DB::table('sentinels')
            ->selectRaw('YEAR(waktu_insiden) as tahun, QUARTER(waktu_insiden) as triwulan')
            ->groupBy('tahun', 'triwulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('triwulan', 'desc')
            ->get();

        return view('datamutu.insiden.sentinel.index', [
            'sentinels' => $data,
            'availablePeriods' => $availablePeriods
        ]);
    }

    public function create()
    {
        if (!auth()->user()->can('insiden.buat')) return abort(403);

        return view('datamutu.insiden.sentinel.create');
    }

    public function store(Request $request, ImageCompressorService $compressor)
    {
        if (!auth()->user()->can('insiden.buat')) return abort(403);

        $validated = $request->validate([
            'no_rm' => 'required|string',
            'nama_pasien' => 'required|string',
            'umur' => 'required|string',
            'jk' => 'required|string',
            'waktu_mskrs' => 'nullable|date',
            'waktu_insiden' => 'nullable|date',
            'temuan' => 'required|string',
            'kronologis' => 'required|string',
            'unit_terkait' => 'required|string',
            'sumber' => 'required|string',
            'rawat' => 'required|string',
            'poli' => 'required|string',
            'lokasi' => 'required|string',
            'tindakan_segera' => 'required|string',
            'pelaksana' => 'required|string',
            'akibat' => 'required|string',
            'nama_inisial' => 'required|string',
            'ruangan_pelapor' => 'required|string',
            'foto' => 'nullable|array|max:5',
            'foto.*' => 'image|max:2048|mimetypes:image/jpeg,image/png,image/webp',
        ]);

        $fotoPaths = [];
        if ($request->hasFile('foto')) {
            $fotoPaths = $compressor->compressAndUpload($request->file('foto'), 'foto_sentinel');
        }

        Sentinel::create([
            'no_rm' => $validated['no_rm'],
            'nama_pasien' => $validated['nama_pasien'],
            'umur' => $validated['umur'],
            'jk' => $validated['jk'],
            'waktu_mskrs' => $validated['waktu_mskrs'] ?? null,
            'waktu_insiden' => $validated['waktu_insiden'] ?? null,
            'temuan' => $validated['temuan'],
            'kronologis' => $validated['kronologis'],
            'unit_terkait' => $validated['unit_terkait'],
            'sumber' => $validated['sumber'],
            'rawat' => $validated['rawat'],
            'poli' => $validated['poli'],
            'lokasi' => $validated['lokasi'],
            'tindakan_segera' => $validated['tindakan_segera'],
            'pelaksana' => $validated['pelaksana'],
            'akibat' => $validated['akibat'],
            'nama_inisial' => $validated['nama_inisial'],
            'ruangan_pelapor' => $validated['ruangan_pelapor'],
            'foto' => $fotoPaths,
        ]);

        return redirect()->route('insiden.sentinel.index')->with('success', 'Data sentinel berhasil disimpan.');
    }

    public function show($id)
    {
        $sentinel = sentinel::findOrFail($id);
        return view('datamutu.insiden.sentinel.show', compact('sentinel'));
    }

    public function destroy(sentinel $sentinel)
    {
        if (!auth()->user()->can('insiden.hapus')) return abort(403);

        $sentinel->delete();
        return redirect()->route('insiden.sentinel.index')->with('success', 'Data sentinel berhasil dihapus.');
    }

    public function export(Request $request)
    {
        ini_set('memory_limit', '1G'); // hanya berlaku untuk export
        ini_set('max_execution_time', '300'); // kalau proses lama

        if (!auth()->user()->can('insiden.export')) return abort(403);

        $triwulan = $request->get('triwulan');
        $tahun = $request->get('tahun');

        $data = Sentinel::query();

        if ($triwulan && $tahun) {
            $awal = Carbon::create($tahun, $triwulan * 3 - 2, 1);
            $akhir = Carbon::create($tahun, $triwulan * 3, 30)->endOfMonth();
            $data = $data->whereDate('waktu_insiden', '>=' , $awal)->whereDate('waktu_insiden', '<=' , $akhir);
        }

        $data = $data->latest()->get();

        foreach ($data as $item) {
            $gambar_base64 = [];

            $gambarArray = $item->foto;

            if (is_array($gambarArray)) {
                foreach ($gambarArray as $namaFile) {
                    $path = public_path('storage/' . $namaFile);
                    if (file_exists($path)) {
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $content = file_get_contents($path);
                        $gambar_base64[] = 'data:image/' . $ext . ';base64,' . base64_encode($content);
                    }
                }
            }

            $item->setAttribute('gambar_base64', $gambar_base64);
        }

        // return view('datamutu.insiden.sentinel.export', [
        //     'data' => $data,
        //     'triwulan' => $triwulan,
        //     'tahun' => $tahun
        // ]);

        $pdf = Pdf::loadView('datamutu.insiden.sentinel.export', compact('data', 'triwulan', 'tahun'))->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ])->setPaper('a4', 'portrait');
        return $pdf->download('Laporan Insiden Sentinel - '.$triwulan.' - '.$tahun.'.pdf');
    }
}
