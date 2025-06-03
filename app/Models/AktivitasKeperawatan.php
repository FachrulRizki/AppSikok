<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AktivitasKeperawatan extends Model
{
    protected $table = 'aktivitas_keperawatan';

    protected $fillable = [
        'waktu',
        'shift',
        'nama_perawat',
        'unit_kerja',
        'aktivitas',
        'catatan'
    ];

    protected $casts = [
        'aktivitas' => 'array',
        'waktu' => 'datetime'
    ];

    //helper
    public function getAktivitasListAttribute()
    {
        return is_array($this->aktivitas) ? implode(', ', $this->aktivitas) : $this->aktivitas;
    }
}
