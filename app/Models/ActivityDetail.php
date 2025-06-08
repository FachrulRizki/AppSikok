<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'activity_id',
        'kode',
        'nama'
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function activity_tasks()
    {
        return $this->hasMany(ActivityTask::class);
    }
}
