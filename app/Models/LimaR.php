<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class LimaR extends Model
{
    use HasFactory;

    protected $table = 'lima_r';

    protected $fillable = [
        'waktu',
        'shift',
        'dilaksanakan',
        'catatan',
        'foto',
        'user_id',
    ];

    protected $casts = [
        'dilaksanakan' => 'array',
        'catatan' => 'array',
        'foto' => 'array',
        'waktu' => 'datetime',
    ];

    protected static function booted()
    {
        static::deleting(function ($lima_r) {
            if (is_array($lima_r->foto)) {
                foreach ($lima_r->foto as $file) {
                    Storage::delete('public/' . $file);
                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
