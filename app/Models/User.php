<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'dob',
        'country',
        'last_login_at',
        'preferences',
        'is_admin',
        'admin_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'dob' => 'date',
        'last_login_at' => 'datetime',
        'preferences' => 'array',
        'is_admin' => 'boolean',
        'admin_verified_at' => 'datetime',
    ];

    public function enrollments()
    {
        return $this->hasMany(UserEnrollment::class);
    }

    public function progress()
    {
        return $this->hasMany(UserProgress::class);
    }

    public function getEnrolledCoursesAttribute()
    {
        return $this->enrollments()->with('course')->get()->pluck('course');
    }

    public function isEnrolledIn($courseId)
    {
        return $this->enrollments()->where('course_id', $courseId)->exists();
    }

    public function getCourseProgress($courseId)
    {
        $enrollment = $this->enrollments()->where('course_id', $courseId)->first();
        return $enrollment ? $enrollment->progress_percentage : 0;
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function makeAdmin()
    {
        $this->update([
            'is_admin' => true,
            'admin_verified_at' => now(),
        ]);
    }

    public function removeAdmin()
    {
        $this->update([
            'is_admin' => false,
            'admin_verified_at' => null,
        ]);
    }
}
