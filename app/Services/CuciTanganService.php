<?php

namespace App\Services;

use App\Models\CuciTangan;
use Illuminate\Support\Facades\Auth;

class CuciTanganService
{
    public static function getActivities()
    {
        return [
            [
                'id' => "1",
                'nama' => 'Audit Kepatuhan Cuci Tangan',
                'details' => [
                    ['id' => "1.1", 'nama' => 'Sebelum kontak dengan pasien', 'tasks' => []],
                    ['id' => "1.2", 'nama' => 'Sebelum tindakan aseptic', 'tasks' => []],
                    ['id' => "1.3", 'nama' => 'Setelah kontak dengan pasien', 'tasks' => []],
                    ['id' => "1.4", 'nama' => 'Setelah terpapar cairan tubuh pasien', 'tasks' => []],
                    ['id' => "1.5", 'nama' => 'Setelah kontak dengan lingkungan pasien', 'tasks' => []],
                ],
            ],
            [
                'id' => "2",
                'nama' => 'Audit Kepatuhan Penggunaan APD',
                'details' => [
                    ['id' => "2.1", 'nama' => 'Pemakaian masker', 'tasks' => []],
                    ['id' => "2.2", 'nama' => 'Pemakaian handscoon', 'tasks' => []],
                    ['id' => "2.3", 'nama' => 'Pemakaian gown', 'tasks' => []],
                    ['id' => "2.4", 'nama' => 'Pemakaianan face shield (kacamata google)', 'tasks' => []],
                    ['id' => "2.5", 'nama' => 'Pemakaian apron', 'tasks' => []],
                ],
            ],
            [
                'id' => "3",
                'nama' => 'Audit Pengelolaan Alat Medis Bekas Pakai di Ruangan',
                'details' => [
                    ['id' => "3.1", 'nama' => 'Dekontaminasi alat medis (non kritikal) bekas pakai dengan alkohol', 'tasks' => []],
                    ['id' => "3.2", 'nama' => 'Pre-cleaning alat medis (semi kritikal & kritikal) dengan tissue/kasa', 'tasks' => []],
                    ['id' => "3.3", 'nama' => 'Alat medis dibawa ke CSSD dalam box tertutup', 'tasks' => []],
                ],
            ],
            [
                'id' => "4",
                'nama' => 'Pengelolaan Limbah Infeksius',
                'details' => [
                    ['id' => "4.1", 'nama' => 'Pemisahan limbah dilakukan segera oleh petugas', 'tasks' => []],
                    ['id' => "4.2", 'nama' => 'Limbah infeksius dimasukkan ke kantong plastik kuning', 'tasks' => []],
                    ['id' => "4.3", 'nama' => 'Limbah non infeksius ke kantong plastik hitam', 'tasks' => []],
                    ['id' => "4.4", 'nama' => 'Limbah ¾ penuh diikat', 'tasks' => []],
                    ['id' => "4.5", 'nama' => 'Limbah benda tajam dibuang ke safety box', 'tasks' => []],
                ],
            ],
            [
                'id' => "5",
                'nama' => 'Edukasi Pasien & Keluarga tentang PPI',
                'details' => [
                    ['id' => "5.1", 'nama' => 'Edukasi pelaksanaan cuci tangan 6 langkah', 'tasks' => []],
                    [
                        'id' => "5.2",
                        'nama' => 'Edukasi momen cuci tangan',
                        'tasks' => [
                            ['id' => "5.2.1", 'nama' => 'Sebelum kontak dengan pasien', 'tipe' => 'Momen'],
                            ['id' => "5.2.2", 'nama' => 'Setelah kontak dengan pasien', 'tipe' => 'Momen'],
                            ['id' => "5.2.3", 'nama' => 'Setelah kontak dengan lingkungan pasien', 'tipe' => 'Momen'],
                        ],
                    ],
                    [
                        'id' => "5.3",
                        'nama' => 'Edukasi penggunaan APD',
                        'tasks' => [
                            ['id' => "5.3.1", 'nama' => 'Penggunaan masker', 'tipe' => 'APD'],
                        ],
                    ],
                    ['id' => "5.4", 'nama' => 'Edukasi etika batuk', 'tasks' => []],
                ],
            ],
            [
                'id' => "6",
                'nama' => 'Pelaporan Kejadian HAIS',
                'details' => [
                    [
                        'id' => "6.1",
                        'nama' => 'Analisis Data',
                        'tasks' => [
                            ['id' => "6.1.1", 'nama' => 'Menghitung angka kejadian (incidence rate)', 'tipe' => 'Analisis'],
                            ['id' => "6.1.2", 'nama' => 'Membuat grafik tren bulanan/kuartalan/tahunan', 'tipe' => 'Analisis'],
                            ['id' => "6.1.3", 'nama' => 'Menyusun laporan analisis', 'tipe' => 'Analisis'],
                        ],
                    ],
                ],
            ],
        ];
    }
    
    public function getAll($request)
    {
        $search = $request->get('search');
        $start = $request->get('start');
        $end = $request->get('end');

        $data = CuciTangan::select(
            'id',
            'waktu',
            'shift',
            'user_id'
        )->with('user');

        if (auth()->user()->can('cuci_tangan.lihat.sendiri')) {
            $data = $data->where('user_id', auth()->user()->id);
        }

        if ($search) {
            $data->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        if ($start && $end) {
            $data = $data->whereDate('waktu', '>=', $start)->whereDate('waktu', '<=', $end);
        }

        return $data->latest()->paginate(10);
    }

    public function store($request)
    {
        return CuciTangan::create([
            'user_id' => auth()->user()->id,
            'waktu' => $request->waktu,
            'shift' => $request->shift,
            'details' => $request->has('details') ? json_encode($request->input('details')) : null,
            'tasks' => $request->has('tasks') ? json_encode($request->input('tasks')) : null,
            'notes' => $request->has('notes') ? json_encode($request->input('notes')) : null,
        ]);
    }

    public function update($cuci_tangan, $request)
    {
        return $cuci_tangan->update([
            'waktu' => $request->waktu,
            'shift' => $request->shift,
            'details' => json_encode($request->input('details', [])),
            'tasks' => json_encode($request->input('tasks', [])),
            'notes' => json_encode($request->input('notes', [])),
        ]);
    }

    public function delete($cuci_tangan)
    {
        return $cuci_tangan->delete();
    }
}
