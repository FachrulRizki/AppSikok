<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KuisonerKepuasan;

class KuisonerKepuasanController extends Controller
{
    public function index()
    {
        $data = KuisonerKepuasan::latest()->paginate(10);
        return view('kuisoner.index', compact('data'));
    }

    public function create()
    {
        return view('kuisoner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'waktu_survei' => 'required|date',
            'jk' => 'required',
            'usia' => 'required|integer',
            'pendidikan' => 'required',
            'pekerjaan' => 'required',
            'hubungan_pasien' => 'required',
            'p1' => 'required|array|min:9', // 9 pertanyaan minimal
            'saran' => 'nullable|string',
        ]);

        // Simpan data
        $kuesioner = new KuisonerKepuasan();
        $kuesioner->waktu_survei = $request->waktu_survei;
        $kuesioner->jk = $request->jk;
        $kuesioner->usia = $request->usia;
        $kuesioner->pendidikan = $request->pendidikan;
        $kuesioner->pekerjaan = $request->pekerjaan;
        $kuesioner->hubungan_pasien = $request->hubungan_pasien;
        $kuesioner->p1 = $request->p1[0] ?? null;
        $kuesioner->p2 = $request->p1[1] ?? null;
        $kuesioner->p3 = $request->p1[2] ?? null;
        $kuesioner->p4 = $request->p1[3] ?? null;
        $kuesioner->p5 = $request->p1[4] ?? null;
        $kuesioner->p6 = $request->p1[5] ?? null;
        $kuesioner->p7 = $request->p1[6] ?? null;
        $kuesioner->p8 = $request->p1[7] ?? null;
        $kuesioner->p9 = $request->p1[8] ?? null;
        $kuesioner->saran = $request->saran;
        // $kuesioner->save();

        KuisonerKepuasan::create($request->all());
        return redirect()->back()->with('success', 'Terima kasih atas partisipasi Anda!');
    }

    public function show($id)
    {
        $data = KuisonerKepuasan::findOrFail($id);
        return view('kuisoner.show', compact('data'));
    }


    public function destroy($id)
    {
        $data = KuisonerKepuasan::findOrFail($id);
        $data->delete();

        return redirect()->route('kuisoner.index')->with('success', 'kuisoner berhasil dihapus.');
    }
}
