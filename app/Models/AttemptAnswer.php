<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttemptAnswer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'quiz_attempt_id',
        'question_id',
        'selected_option',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function getOptionAttribute()
    {
        $option = Option::where('question_id', $this->question_id)->where('option_label', $this->selected_option)->first();

        return $option->option_text;
    }

    public function getIsCorrectOptionAttribute()
    {
        return $this->selected_option == $this->question->correct_option;
    }

    public function getCorrectOptionAttribute()
    {
        return Option::where('question_id', $this->question_id)->where('option_label', $this->question->correct_option)->first();
    }
}
