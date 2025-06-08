<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityTask extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'activity_detail_id',
        'tipe',
        'urutan',
        'nama'
    ];

    public function activityDetail()
    {
        return $this->belongsTo(ActivityDetail::class);
    }
}
