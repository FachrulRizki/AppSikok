<?php

namespace App\Http\Controllers;

use App\Exports\KpcExport;
use Illuminate\Http\Request;
use App\Models\Kpc;
use App\Services\ImageCompressorService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class KpcController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->can('insiden.list')) return abort(403);

        $triwulan = $request->get('triwulan');
        $tahun = $request->get('tahun');

        $data = Kpc::query();

        if ($triwulan && $tahun) {
            $awal = Carbon::create($tahun, $triwulan * 3 - 2, 1);
            $akhir = Carbon::create($tahun, $triwulan * 3, 30)->endOfMonth();
            $data = $data->whereDate('waktu', '>=' , $awal)->whereDate('waktu', '<=' , $akhir);
        }

        $data = $data->latest()->paginate(10);

        $availablePeriods = DB::table('kpcs')
            ->selectRaw('YEAR(waktu) as tahun, QUARTER(waktu) as triwulan')
            ->groupBy('tahun', 'triwulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('triwulan', 'desc')
            ->get();
        
        return view('datamutu.insiden.kpc.index', [
            'kpcs' => $data,
            'availablePeriods' => $availablePeriods
        ]);
    }

    public function create()
    {
        if (!auth()->user()->can('insiden.buat')) return abort(403);

        return view('datamutu.insiden.kpc.create');
    }

    public function store(Request $request, ImageCompressorService $compressor)
    {
        if (!auth()->user()->can('insiden.buat')) return abort(403);

        $request->validate([
            'waktu' => 'required|date',
            'temuan' => 'required|string',
            'kronologis' => 'required|string',
            'sumber' => 'required|string',
            'unit_terkait' => 'required|string',
            'ruangan' => 'required|string',
            'tindakan' => 'required|string',
            'pelaksana' => 'required|string',
            'nama_inisial' => 'required|string',
            'foto' => 'nullable|array|max:5',
            'foto.*' => 'image|max:2048|mimetypes:image/jpeg,image/png,image/webp',
        ]);

        // Upload dan simpan path foto
        $fotoPaths = [];
        if ($request->hasFile('foto')) {
            $fotoPaths = $compressor->compressAndUpload($request->file('foto'), 'foto_kpc');
        }

        Kpc::create([
            'waktu' => $request->waktu,
            'temuan' => $request->temuan,
            'kronologis' => $request->kronologis,
            'sumber' => $request->sumber,
            'unit_terkait' => $request->unit_terkait,
            'ruangan' => $request->ruangan,
            'tindakan' => $request->tindakan,
            'pelaksana' => $request->pelaksana,
            'nama_inisial' => $request->nama_inisial,
            'foto' => $fotoPaths,
        ]);

        activity()
            ->event('Buat Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Membuat Data KPC');

        return redirect()->route('insiden.kpc.index')->with('success', 'Data insiden KPC berhasil disimpan');
    }

    public function show($id)
    {
        $kpc = Kpc::findOrFail($id);
        return view('datamutu.insiden.kpc.show', compact('kpc'));
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('insiden.hapus')) return abort(403);

        $kpc = Kpc::findOrFail($id);
        $kpc->delete();

        activity()
            ->event('Hapus Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Menghapus Data KPC');

        return redirect()->route('insiden.kpc.index')->with('success', 'Data Insiden KPC berhasil dihapus');
    }

    public function export(Request $request)
    {
        if (!auth()->user()->can('insiden.export')) return abort(403);

        $triwulan = $request->get('triwulan');
        $tahun = $request->get('tahun');

        $data = Kpc::query();

        if ($triwulan && $tahun) {
            $awal = Carbon::create($tahun, $triwulan * 3 - 2, 1);
            $akhir = Carbon::create($tahun, $triwulan * 3, 30)->endOfMonth();
            $data = $data->whereDate('waktu', '>=' , $awal)->whereDate('waktu', '<=' , $akhir);
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

        // return view('datamutu.insiden.kpc.export', [
        //     'data' => $data,
        //     'triwulan' => $triwulan,
        //     'tahun' => $tahun
        // ]);

        $pdf = Pdf::loadView('datamutu.insiden.kpc.export', compact('data', 'triwulan', 'tahun'))->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ])->setPaper('a4', 'portrait');

        activity()
            ->event('Export Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Mengexport Data KPC');

        return $pdf->download('Laporan Insiden KPC - '.$triwulan.' - '.$tahun.'.pdf');
    }
}
