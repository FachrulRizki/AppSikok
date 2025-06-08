<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'kode',
        'nama'
    ];

    public function activity_details()
    {
        return $this->hasMany(ActivityDetail::class);
    }
}
