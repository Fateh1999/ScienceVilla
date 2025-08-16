<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\UserEnrollment;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get user's enrollments with course data
        $enrollments = UserEnrollment::with(['course.lessons', 'course.quizzes'])
            ->where('user_id', $user->id)
            ->latest('enrolled_at')
            ->get();

        // Get recent progress
        $recentProgress = UserProgress::with(['lesson.course'])
            ->where('user_id', $user->id)
            ->latest('updated_at')
            ->take(5)
            ->get();

        // Get available courses for the user's country
        $availableCourses = Course::active()
            ->forCountry($user->country)
            ->whereNotIn('id', $enrollments->pluck('course_id'))
            ->take(6)
            ->get();

        // Calculate overall statistics
        $stats = [
            'total_enrollments' => $enrollments->count(),
            'completed_courses' => $enrollments->where('completed_at', '!=', null)->count(),
            'in_progress_courses' => $enrollments->where('completed_at', null)->count(),
            'total_lessons_completed' => UserProgress::where('user_id', $user->id)
                ->where('completed_at', '!=', null)->count(),
            'total_study_time' => $this->calculateTotalStudyTime($user->id),
            'certificates_earned' => $enrollments->where('certificate_issued_at', '!=', null)->count(),
        ];

        return view('student.dashboard', compact(
            'user',
            'enrollments',
            'recentProgress',
            'availableCourses',
            'stats'
        ));
    }

    public function courses()
    {
        $user = Auth::user();
        
        // Get user's enrolled courses
        $enrolledCourses = UserEnrollment::with(['course.lessons'])
            ->where('user_id', $user->id)
            ->paginate(12);

        return view('student.courses', compact('enrolledCourses'));
    }

    public function browseCourses()
    {
        $user = Auth::user();
        
        // Get available courses for user's country
        $courses = Course::active()
            ->forCountry($user->country)
            ->with('lessons')
            ->paginate(12);

        // Get user's enrolled course IDs
        $enrolledCourseIds = UserEnrollment::where('user_id', $user->id)
            ->pluck('course_id')
            ->toArray();

        return view('student.browse-courses', compact('courses', 'enrolledCourseIds'));
    }

    public function enrollCourse(Course $course)
    {
        $user = Auth::user();

        // Check if course is available in user's country
        if (!in_array($user->country, $course->countries ?? [])) {
            return back()->with('error', 'This course is not available in your country.');
        }

        // Check if already enrolled
        $existingEnrollment = UserEnrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingEnrollment) {
            return back()->with('info', 'You are already enrolled in this course.');
        }

        // Create enrollment
        UserEnrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'enrolled_at' => now(),
            'progress_percentage' => 0,
        ]);

        return redirect()->route('student.course.view', $course)
            ->with('success', 'Successfully enrolled in ' . $course->title . '!');
    }

    public function viewCourse(Course $course)
    {
        $user = Auth::user();

        // Check if user is enrolled
        $enrollment = UserEnrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            return redirect()->route('student.browse-courses')
                ->with('error', 'You must enroll in this course first.');
        }

        // Get lessons with progress
        $lessons = $course->lessons()->active()->orderBy('sort_order')->get();
        
        // Get user's progress for each lesson
        $progressData = UserProgress::where('user_id', $user->id)
            ->whereIn('lesson_id', $lessons->pluck('id'))
            ->get()
            ->keyBy('lesson_id');

        // Add progress data to lessons
        $lessons->each(function ($lesson) use ($progressData) {
            $lesson->user_progress = $progressData->get($lesson->id);
        });

        return view('student.course-view', compact('course', 'enrollment', 'lessons'));
    }

    public function viewLesson(Course $course, $lessonId)
    {
        $user = Auth::user();

        // Check enrollment
        $enrollment = UserEnrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            return redirect()->route('student.browse-courses')
                ->with('error', 'You must enroll in this course first.');
        }

        $lesson = $course->lessons()->where('id', $lessonId)->active()->firstOrFail();
        
        // Get or create progress record
        $progress = UserProgress::firstOrCreate([
            'user_id' => $user->id,
            'lesson_id' => $lesson->id,
        ], [
            'progress_percentage' => 0,
        ]);

        // Get next and previous lessons
        $nextLesson = $course->lessons()->active()
            ->where('sort_order', '>', $lesson->sort_order)
            ->orderBy('sort_order')
            ->first();

        $previousLesson = $course->lessons()->active()
            ->where('sort_order', '<', $lesson->sort_order)
            ->orderBy('sort_order', 'desc')
            ->first();

        return view('student.lesson-view', compact(
            'course',
            'lesson',
            'progress',
            'nextLesson',
            'previousLesson'
        ));
    }

    public function markLessonComplete(Request $request, Course $course, $lessonId)
    {
        $user = Auth::user();

        $progress = UserProgress::where('user_id', $user->id)
            ->where('lesson_id', $lessonId)
            ->first();

        if ($progress) {
            $progress->markAsCompleted();
            
            // Update course enrollment progress
            $enrollment = UserEnrollment::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->first();
                
            if ($enrollment) {
                $enrollment->updateProgress();
            }
        }

        return response()->json(['success' => true]);
    }

    public function profile()
    {
        $user = Auth::user();
        
        // Get user statistics
        $stats = [
            'total_enrollments' => UserEnrollment::where('user_id', $user->id)->count(),
            'completed_courses' => UserEnrollment::where('user_id', $user->id)
                ->whereNotNull('completed_at')->count(),
            'certificates_earned' => UserEnrollment::where('user_id', $user->id)
                ->whereNotNull('certificate_issued_at')->count(),
            'total_study_time' => $this->calculateTotalStudyTime($user->id),
        ];

        return view('student.profile', compact('user', 'stats'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        $countries = ['in' => 'India', 'uk' => 'United Kingdom', 'us' => 'United States', 'ca' => 'Canada', 'au' => 'Australia'];
        return view('student.edit-profile', compact('user', 'countries'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'dob' => 'nullable|date',
            'country' => 'required|in:in,uk,us,ca,au',
        ]);

        $user->update($request->only(['name', 'email', 'dob', 'country']));

        return redirect()->route('student.profile')->with('success', 'Profile updated successfully.');
    }

    private function calculateTotalStudyTime($userId)
    {
        // Calculate based on completed lessons and their duration
        $completedLessons = UserProgress::with('lesson')
            ->where('user_id', $userId)
            ->whereNotNull('completed_at')
            ->get();

        return $completedLessons->sum(function ($progress) {
            return $progress->lesson->duration_minutes ?? 0;
        });
    }
}
