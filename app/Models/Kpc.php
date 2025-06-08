<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    /**
     * Relasi ke model LampiranFoto
     * Satu KPC bisa memiliki banyak lampiran foto
     */
    // public function lampiran_foto()
    // {
    //     return $this->hasMany(LampiranFotoKpc::class, 'kpc_id');
    // }
}
