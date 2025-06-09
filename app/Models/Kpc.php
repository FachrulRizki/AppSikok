<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Kpc extends Model
{
    use HasFactory;

    protected $fillable = [
        'waktu',
        'temuan',
        'kronologis',
        'sumber',
        'unit_terkait',
        'ruangan',
        'tindakan',
        'pelaksana',
        'nama_inisial',
        'foto',
    ];

    protected $casts = [
        'waktu' => 'datetime',
        'foto' => 'array'
    ];

    protected static function booted()
    {
        static::deleting(function ($kpc) {
            if (is_array($kpc->foto)) {
                foreach ($kpc->foto as $file) {
                    Storage::delete('public/' . $file);
                }
            }
        });
    }
}
