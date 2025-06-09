<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Ktd extends Model
{
    use HasFactory;

    protected $table = 'ktds';

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
        'tindakan_segera',
        'pelaksana',
        'akibat',
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
        static::deleting(function ($ktd) {
            if (is_array($ktd->foto)) {
                foreach ($ktd->foto as $file) {
                    Storage::delete('public/' . $file);
                }
            }
        });
    }
}
