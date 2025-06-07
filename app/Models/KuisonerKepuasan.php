<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuisonerKepuasan extends Model
{
    use HasFactory;

    protected $table = 'kuisoner_kepuasan';

    protected $fillable = [
        'waktu_survei',
        'jk',
        'usia',
        'pendidikan',
        'pekerjaan',
        'hubungan_pasien',
        'p1',
        'p2',
        'p3',
        'p4',
        'p5',
        'p6',
        'p7',
        'p8',
        'p9',
        'saran',
    ];

    protected $casts = [
        'waktu_survei' => 'datetime',
    ];
}
