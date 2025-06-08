<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpvKepru extends Model
{
    protected $table = 'spv_kepru';

    protected $fillable = [
        'waktu',
        'ruangan',
        'shift',
        'aktivitas',
        'observasi',
        'perbaikan',
        'user_id'
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}