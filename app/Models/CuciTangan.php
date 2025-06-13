<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuciTangan extends Model
{
    use HasFactory;

    protected $table = 'cuci_tangan';

    protected $fillable = [
        'user_id',
        'ruangan',
        'shift',
        'waktu',
        'dilaksanakan',
        'catatan',
    ];

    protected $casts = [
        'waktu' => 'datetime',
        'dilaksanakan' => 'array',
        'catatan' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
