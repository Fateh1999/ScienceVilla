<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'chapter_id',
        'question',
        'options',
        'correct_answer_index',
        'difficulty',
        'order_index',
        'is_active'
    ];

    protected $casts = [
        'options' => 'array',
        'correct_answer_index' => 'integer',
        'is_active' => 'boolean'
    ];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function getCorrectAnswerAttribute()
    {
        return $this->options[$this->correct_answer_index] ?? null;
    }

    public function isCorrectAnswer($answerIndex)
    {
        return $answerIndex == $this->correct_answer_index;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByDifficulty($query, $difficulty)
    {
        return $query->where('difficulty', $difficulty);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_index');
    }
}
