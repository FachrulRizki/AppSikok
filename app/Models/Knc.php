<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class Knc extends Model
{
    use HasFactory;

    protected $table = 'kncs'; // Ganti sesuai nama tabel di database jika berbeda

    protected $fillable = [
        'no_rm',
        'nama_pasien',
        'umur',
        'jk',
        'waktu_mskrs',
        'waktu_insiden',
        'temuan',
        'kronologis',
        'tindakan_segera',
        'insiden_pada',
        'unit_terkait',
        'sumber',
        'rawat',
        'poli',
        'pelaksana',
        'nama_inisial',
        'ruangan_pelapor',
        'foto',
    ];

    protected $casts = [
        'waktu_mskrs' => 'datetime',
        'waktu_insiden' => 'datetime',
        'foto' => 'array',
    ];

    protected static function booted()
    {
        static::deleting(function ($knc) {
            if (is_array($knc->foto)) {
                foreach ($knc->foto as $file) {
                    Storage::delete('public/' . $file);
                }
            }
        });
    }
}
