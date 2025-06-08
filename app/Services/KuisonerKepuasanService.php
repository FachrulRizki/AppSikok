<?php

namespace App\Services;

use App\Models\KuisonerKepuasan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class KuisonerKepuasanService
{
    /**
     * Simpan data kuesioner kepuasan.
     *
     * @param array $data
     * @return KuisonerKepuasan
     * @throws ValidationException
     */
    public function simpan(array $data): KuisonerKepuasan
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
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return KuisonerKepuasan::create($validator->validated());
    }

    /**
     * Ambil semua data kuesioner
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function semua()
    {
        return KuisonerKepuasan::orderByDesc('waktu_survei')->get();
    }

    /**
     * Hapus data berdasarkan ID.
     *
     * @param int $id
     * @return bool
     */
    public function hapus(int $id): bool
    {
        $kuesioner = KuisonerKepuasan::findOrFail($id);
        return $kuesioner->delete();
    }
}
