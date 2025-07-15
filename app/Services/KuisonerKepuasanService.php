<?php

namespace App\Services;

use App\Models\KuisonerKepuasan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class KuisonerKepuasanService
{
    public function simpan(array $data)
    {
        $validator = Validator::make($data, [
            'waktu_survei' => 'required|date',
            'jk' => 'required|in:L,P',
            'usia' => 'required|numeric|min:1|max:120',
            'pendidikan' => 'required|string|max:100',
            'pekerjaan' => 'required|string|max:100',
            'hubungan_pasien' => 'required|string|max:100',
            'p1' => 'required|integer|between:1,4',
            'p2' => 'required|integer|between:1,4',
            'p3' => 'required|integer|between:1,4',
            'p4' => 'required|integer|between:1,4',
            'p5' => 'required|integer|between:1,4',
            'p6' => 'required|integer|between:1,4',
            'p7' => 'required|integer|between:1,4',
            'p8' => 'required|integer|between:1,4',
            'p9' => 'required|integer|between:1,4',
            'saran' => 'nullable|string|max:1000',
            'ruangan' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        KuisonerKepuasan::create($validator->validated());

        return activity()
            ->event('Buat Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Membuat Kuesioner Kepuasan');
    }

    public function semua()
    {
        return KuisonerKepuasan::orderByDesc('waktu_survei')->get();
    }

    public function hapus(int $id)
    {
        $kuesioner = KuisonerKepuasan::findOrFail($id);
        $kuesioner->delete();

        return activity()
            ->event('Hapus Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Menghapus Kuesioner Kepuasan');
    }
}
