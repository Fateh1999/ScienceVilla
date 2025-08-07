<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserEnrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'enrolled_at',
        'completed_at',
        'progress_percentage',
        'total_time_spent_minutes',
        'certificate_data',
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
        'completed_at' => 'datetime',
        'progress_percentage' => 'decimal:2',
        'certificate_data' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function isCompleted(): bool
    {
        return !is_null($this->completed_at);
    }

    public function markAsCompleted()
    {
        $this->update([
            'completed_at' => now(),
            'progress_percentage' => 100,
        ]);
    }

    public function updateProgress()
    {
        $progress = $this->course->getProgressForUser($this->user_id);
        $this->update(['progress_percentage' => $progress]);
        
        if ($progress >= 100 && !$this->completed_at) {
            $this->markAsCompleted();
        }
    }
}
