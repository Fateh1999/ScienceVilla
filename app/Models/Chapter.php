<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'order_index',
        'video_id',
        'summary',
        'is_active'
    ];

    protected $casts = [
        'summary' => 'array',
        'is_active' => 'boolean'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function quizQuestions()
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('order_index');
    }

    public function getQuizByDifficulty($difficulty = 'medium')
    {
        return $this->quizQuestions()
            ->where('difficulty', $difficulty)
            ->where('is_active', true)
            ->get();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_index');
    }
}
