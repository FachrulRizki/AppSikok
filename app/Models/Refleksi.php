<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refleksi extends Model
{
    protected $table = 'refleksi';

    protected $guarded = ['id'];

    protected $fillable = [
        'waktu',
        'jdl_kegiatan',
        'user_id',
        'poin_materi',
        'pribadi',
        'tindakan',
        'approvement',
        'nilai',
        'humanity_score_id',
        'feedback',
    ];

    protected $casts = [
        'waktu' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function humanityScore()
    {
        return $this->belongsTo(HumanityScore::class);
    }
}
