<?php

namespace App\Services;

use App\Models\ktc;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class KtcService
{
    public function store(array $data): ktc
    {
        // Validasi data dasar dan file
        $validator = Validator::make($data, [
            'no_rm' => 'required|string',
            'nama_pasien' => 'required|string',
            'umur' => 'required|numeric',
            'jk' => 'required|in:L,P',
            'waktu_mskrs' => 'nullable|date',
            'waktu_insiden' => 'nullable|date',
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
            'foto.*' => 'nullable|image|max:2048'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Simpan data ke tabel ktcs
        return Ktc::create([
            'no_rm' => $data['no_rm'],
            'nama_pasien' => $data['nama_pasien'],
            'umur' => $data['umur'],
            'jk' => $data['jk'],
            'waktu_mskrs' => $data['waktu_mskrs'] ?? null,
            'waktu_insiden' => $data['waktu_insiden'] ?? null,
            'temuan' => $data['temuan'],
            'kronologis' => $data['kronologis'],
            'unit_terkait' => $data['unit_terkait'],
            'sumber' => $data['sumber'],
            'rawat' => $data['rawat'],
            'poli' => $data['poli'],
            'lokasi' => $data['lokasi'] ?? null,
            'unit' => $data['unit'] ?? null,
            'tindakan_segera' => $data['tindakan_segera'] ?? null,
            'pelaksana' => $data['pelaksana'],
            'nama_inisial' => $data['nama_inisial'],
            'ruangan_pelapor' => $data['ruangan_pelapor'],
        ]);

        // Simpan foto jika ada (maksimal 5 foto)
        if (isset($data['foto']) && is_array($data['foto'])) {
            $fotos = array_slice($data['foto'], 0, 5);

            foreach ($fotos as $file) {
                $path = $file->store('foto_ktc', 'public');

                $ktc->lampiran_foto()->create([
                    'path' => $path,
                ]);
            }
        }

        return $ktc;
    }
}
