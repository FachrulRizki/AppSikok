<?php

namespace App\Http\Controllers;

use App\Exports\KtcExport;
use App\Services\KtcService;
use App\Models\Ktc;
use App\Services\ImageCompressorService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class KtcController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('insiden.list')) return abort(403);

        $triwulan = $request->get('triwulan');
        $tahun = $request->get('tahun');

        $data = Ktc::query();

        if ($triwulan && $tahun) {
            $awal = Carbon::create($tahun, $triwulan * 3 - 2, 1);
            $akhir = Carbon::create($tahun, $triwulan * 3, 30)->endOfMonth();
            $data = $data->whereDate('waktu_insiden', '>=' , $awal)->whereDate('waktu_insiden', '<=' , $akhir);
        }

        $data = $data->latest()->paginate(10);

        $availablePeriods = DB::table('ktcs')
            ->selectRaw('YEAR(waktu_insiden) as tahun, QUARTER(waktu_insiden) as triwulan')
            ->groupBy('tahun', 'triwulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('triwulan', 'desc')
            ->get();

        return view('datamutu.insiden.ktc.index', [
            'ktcs' => $data,
            'availablePeriods' => $availablePeriods
        ]);
    }

    public function create()
    {
        if (!auth()->user()->can('insiden.buat')) return abort(403);

        return view('datamutu.insiden.ktc.create');
    }

    public function store(Request $request, ImageCompressorService $compressor)
    {
        if (!auth()->user()->can('insiden.buat')) return abort(403);

        $validated = $request->validate([
            'no_rm' => 'required|string|max:100',
            'nama_pasien' => 'required|string|max:255',
            'umur' => 'required|string|max:10',
            'jk' => 'required|in:Laki-Laki,Perempuan',
            'waktu_mskrs' => 'required|date',
            'waktu_insiden' => 'required|date',
            'temuan' => 'required|string',
            'kronologis' => 'required|string',
            'unit_terkait' => 'required|string',
            'sumber' => 'required|string',
            'rawat' => 'required|string',
            'poli' => 'required|string',
            'lokasi' => 'required|string',
            'unit' => 'required|string',
            'tindakan_segera' => 'required|string',
            'pelaksana' => 'required|string',
            'nama_inisial' => 'required|string',
            'ruangan_pelapor' => 'required|string',
            'foto' => 'required|array|max:5',
            'foto.*' => 'image|max:2048|mimetypes:image/jpeg,image/png,image/webp',
        ]);

        $fotoPaths = [];
        if ($request->hasFile('foto')) {
            $fotoPaths = $compressor->compressAndUpload($request->file('foto'), 'foto_ktc');
        }

        Ktc::create([
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
            'unit' => $validated['unit'],
            'tindakan_segera' => $validated['tindakan_segera'],
            'pelaksana' => $validated['pelaksana'],
            'nama_inisial' => $validated['nama_inisial'],
            'ruangan_pelapor' => $validated['ruangan_pelapor'],
            'foto' => $fotoPaths,
        ]);

        activity()
            ->event('Buat Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Membuat Data KTC');

        return redirect()->route('insiden.ktc.index')->with('success', 'Data Laporan KTC berhasil disimpan.');
    }

    public function show($id)
    {
        $ktc = ktc::findOrFail($id);
        return view('datamutu.insiden.ktc.show', compact('ktc'));
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('insiden.hapus')) return abort(403);

        $ktc = ktc::findOrFail($id);
        $ktc->delete();

        activity()
            ->event('Hapus Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Menghapus Data KTC');

        return redirect()->route('insiden.ktc.index')->with('success', 'Data Laporan KTC berhasil dihapus.');
    }

    public function export(Request $request)
    {
        ini_set('memory_limit', '1G'); // hanya berlaku untuk export
        ini_set('max_execution_time', '300'); // kalau proses lama

        if (!auth()->user()->can('insiden.export')) return abort(403);

        $triwulan = $request->get('triwulan');
        $tahun = $request->get('tahun');

        $data = Ktc::query();

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

        // return view('datamutu.insiden.ktc.export', [
        //     'data' => $data,
        //     'triwulan' => $triwulan,
        //     'tahun' => $tahun
        // ]);

        $pdf = Pdf::loadView('datamutu.insiden.ktc.export', compact('data', 'triwulan', 'tahun'))->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ])->setPaper('a4', 'portrait');

        activity()
            ->event('Export Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Menghapus Data KTC');

        return $pdf->download('Laporan Insiden KTC - '.$triwulan.' - '.$tahun.'.pdf');
    }
}
