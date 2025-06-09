<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class Ktc extends Model
{
    use HasFactory;

    protected $table = 'ktcs';

    protected $fillable = [
        'no_rm',
        'nama_pasien',
        'umur',
        'jk',
        'waktu_mskrs',
        'waktu_insiden',
        'temuan',
        'kronologis',
        'unit_terkait',
        'sumber',
        'rawat',
        'poli',
        'lokasi',
        'unit',
        'tindakan_segera',
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
        static::deleting(function ($ktc) {
            if (is_array($ktc->foto)) {
                foreach ($ktc->foto as $file) {
                    Storage::delete('public/' . $file);
                }
            }
        });
    }
}
