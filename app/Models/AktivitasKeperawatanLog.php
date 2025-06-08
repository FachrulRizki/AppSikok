<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AktivitasKeperawatanLog extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'aktivitas_keperawatan_id',
        'activity_id',
        'activity_detail_id',
        'activity_task_id',
        'catatan',  
    ];

    public function aktivitas_keperawatan()
    {
        return $this->belongsTo(AktivitasKeperawatan::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function activity_detail()
    {
        return $this->belongsTo(ActivityDetail::class);
    }

    public function activity_task()
    {
        return $this->belongsTo(ActivityTask::class);
    }
}
