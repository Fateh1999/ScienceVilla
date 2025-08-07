<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'title',
        'description',
        'questions',
        'passing_score',
        'time_limit_minutes',
        'is_active',
    ];

    protected $casts = [
        'questions' => 'array',
        'is_active' => 'boolean',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function calculateScore(array $answers): int
    {
        $totalQuestions = count($this->questions);
        if ($totalQuestions === 0) return 0;

        $correctAnswers = 0;
        foreach ($this->questions as $index => $question) {
            $userAnswer = $answers[$index] ?? null;
            if ($userAnswer === $question['correct_answer']) {
                $correctAnswers++;
            }
        }

        return round(($correctAnswers / $totalQuestions) * 100);
    }

    public function isPassing(int $score): bool
    {
        return $score >= $this->passing_score;
    }
}
