<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpvKepru extends Model
{
    protected $table = 'spv_kepru';

    protected $fillable = [
        'waktu',
        'nm_kepru',
        'shift',
        'aktivitas',
        'observasi',
        'perbaikan'
    ];

    protected $casts = [
        'waktu' => 'datetime',
        'aktivitas' => 'array',
    ];

    //helper
    public function getAktivitasListAttribute()
    {
        return is_array($this->aktivitas) ? implode(', ', $this->aktivitas) : $this->aktivitas;
    }
}