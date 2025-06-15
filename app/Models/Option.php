<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'question_id',
        'option_label',
        'option_text',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
