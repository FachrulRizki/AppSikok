<?php

namespace App\Services;

use App\Models\Kpc;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class KpcService
{
    public function store(array $data): Kpc
    {
        // Validasi data dasar dan file
        $validator = Validator::make($data, [
            'waktu' => 'required|date',
            'temuan' => 'required|string',
            'kronologis' => 'required|string',
            'sumber' => 'required|string',
            'unit_terkait' => 'required|string',
            'ruangan' => 'required|string',
            'tindakan' => 'required|string',
            'pelaksana' => 'required|string',
            'nama_inisial' => 'required|string',
            'foto.*' => 'nullable|image|max:102400', // maks 100MB per file
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Simpan ke tabel `kpcs`
        $kpc = Kpc::create([
            'waktu' => $data['waktu'],
            'temuan' => $data['temuan'],
            'kronologis' => $data['kronologis'],
            'sumber' => $data['sumber'],
            'unit_terkait' => $data['unit_terkait'],
            'ruangan' => $data['ruangan'],
            'tindakan' => $data['tindakan'],
            'pelaksana' => $data['pelaksana'],
            'nama_inisial' => $data['nama_inisial'],
        ]);

        // Simpan foto jika ada
        if (isset($data['foto']) && is_array($data['foto'])) {
            $fotos = array_slice($data['foto'], 0, 5); // batasi maksimal 5 file

            foreach ($fotos as $file) {
                $path = $file->store('foto_kpc', 'public');

                // Jika kamu pakai relasi model
                $kpc->lampiran_foto()->create([
                    'path' => $path,
                ]);
            }
        }

        return $kpc;
    }
}
