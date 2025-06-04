<?php

namespace App\Services;

use App\Models\Knc;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class KncService
{
    public function store(array $data): Knc
    {
        // Validasi data dasar dan file
        $validator = Validator::make($data, [
            'no_rm' => 'required|string|max:100',
            'nama_pasien' => 'required|string|max:255',
            'umur' => 'required|string|max:50',
            'jk' => 'required|in:Laki-Laki,Perempuan',
            'waktu_mskrs' => 'nullable|date',
            'waktu_insiden' => 'nullable|date',
            'temuan' => 'required|string',
            'kronologis' => 'required|string',
            'unit_terkait' => 'required|string|max:255',
            'sumber' => 'required|string',
            'rawat' => 'required|string',
            'poli' => 'required|string',
            'pelaksana' => 'required|string',
            'nama_inisial' => 'required|string',
            'ruangan_pelapor' => 'required|string',
            'foto.*' => 'nullable|image|max:2048'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Simpan data ke tabel kncs
        $knc = Knc::create([
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
            'pelaksana' => $data['pelaksana'],
            'nama_inisial' => $data['nama_inisial'],
            'ruangan_pelapor' => $data['ruangan_pelapor'],
        ]);

        // Simpan foto jika ada (maksimal 5 foto)
        if (isset($data['foto']) && is_array($data['foto'])) {
            $fotos = array_slice($data['foto'], 0, 5);

            foreach ($fotos as $file) {
                $path = $file->store('foto_knc', 'public');

                $knc->lampiran_foto()->create([
                    'path' => $path,
                ]);
            }
        }

        return $knc;
    }
}
