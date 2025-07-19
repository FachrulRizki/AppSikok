<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HumanityScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'score',
        'category',
        'description',
    ];

    public function refleksi()
    {
        return $this->hasMany(Refleksi::class);
    }
}
