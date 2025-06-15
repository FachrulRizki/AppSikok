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
        'shift',
        'waktu',
        'details',
        'tasks',
        'notes'
    ];

    protected $casts = [
        'waktu' => 'datetime',
        'details' => 'array',
        'tasks' => 'array',
        'notes' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
