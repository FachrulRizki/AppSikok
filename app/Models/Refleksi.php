<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refleksi extends Model
{
    protected $table = 'refleksi';

    protected $fillable = [
        'waktu',
        'jdl_kegiatan',
        'unit_kerja',
        'nm_peserta',
        'poin_materi',
        'pribadi',
        'tindakan',
    ];

    protected $casts = [
        'waktu' => 'datetime',
    ];
}
