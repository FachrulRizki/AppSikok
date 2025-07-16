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
        'user_id',
        'catatan',
        'nilai',
        'approvement',
        'feedback'
    ];

    protected $casts = [
        'waktu' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        return $this->hasMany(AktivitasKeperawatanLog::class);
    }
}
