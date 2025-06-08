<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sentinel extends Model
{
    use HasFactory;

    protected $table = 'sentinels';

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
        'foto', // bisa berupa JSON string array jika multiple
    ];

    protected $casts = [
        'waktu_mskrs' => 'datetime',
        'waktu_insiden' => 'datetime',
        'foto' => 'array', // jika disimpan sebagai array json
    ];
}
