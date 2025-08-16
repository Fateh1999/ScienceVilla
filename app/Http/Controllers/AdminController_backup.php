<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use App\Models\UserEnrollment;
use App\Models\UserProgress;
use App\Models\Chapter;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{

    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_courses' => Course::count(),
            'total_lessons' => Lesson::count(),
            'total_enrollments' => UserEnrollment::count(),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_enrollments' => UserEnrollment::with(['user', 'course'])->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    // User Management
    public function users()
    {
        $users = User::with('enrollments')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'country' => 'required|in:in,uk,us,ca,au',
            'is_admin' => 'boolean',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'country' => $request->country,
            'is_admin' => $request->boolean('is_admin'),
            'admin_verified_at' => $request->boolean('is_admin') ? now() : null,
        ]);

        return redirect()->route('admin.users')->with('success', 'User created successfully.');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'country' => 'required|in:in,uk,us,ca,au',
            'is_admin' => 'boolean',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'country' => $request->country,
            'is_admin' => $request->boolean('is_admin'),
            'admin_verified_at' => $request->boolean('is_admin') ? ($user->admin_verified_at ?? now()) : null,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    public function deleteUser(User $user)
    {
        if ($user->is_admin && User::where('is_admin', true)->count() <= 1) {
            return back()->with('error', 'Cannot delete the last admin user.');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    // Course Management
    public function courses()
    {
        $courses = Course::with('lessons')->paginate(20);
        return view('admin.courses.index', compact('courses'));
    }

    public function createCourse()
    {
        return view('admin.courses.create');
    }

    public function storeCourse(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|in:beginner,intermediate,advanced',
            'duration_hours' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'countries' => 'required|array',
            'countries.*' => 'in:in,uk,us,ca,au',
            'image_url' => 'nullable|url',
        ]);

        Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'slug' => Str::slug($request->title),
            'level' => $request->level,
            'duration_hours' => $request->duration_hours,
            'price' => $request->price,
            'countries' => $request->countries,
            'image_url' => $request->image_url,
            'is_active' => true,
            'sort_order' => Course::max('sort_order') + 1,
        ]);

        return redirect()->route('admin.courses')->with('success', 'Course created successfully.');
    }

    public function editCourse(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function updateCourse(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|in:beginner,intermediate,advanced',
            'duration_hours' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'countries' => 'required|array',
            'countries.*' => 'in:in,uk,us,ca,au',
            'image_url' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        $course->update([
            'title' => $request->title,
            'description' => $request->description,
            'slug' => Str::slug($request->title),
            'level' => $request->level,
            'duration_hours' => $request->duration_hours,
            'price' => $request->price,
            'countries' => $request->countries,
            'image_url' => $request->image_url,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.courses')->with('success', 'Course updated successfully.');
    }

    public function deleteCourse(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses')->with('success', 'Course deleted successfully.');
    }

    // Lesson Management
    public function lessons(Course $course)
    {
        $lessons = $course->lessons()->orderBy('sort_order')->paginate(20);
        return view('admin.lessons.index', compact('course', 'lessons'));
    }

    public function createLesson(Course $course)
    {
        return view('admin.lessons.create', compact('course'));
    }

    public function storeLesson(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'video_url' => 'nullable|url',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $course->lessons()->create([
            'title' => $request->title,
            'description' => $request->description,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'video_url' => $request->video_url,
            'duration_minutes' => $request->duration_minutes,
            'sort_order' => $course->lessons()->max('sort_order') + 1,
            'is_active' => true,
        ]);

        return redirect()->route('admin.lessons', $course)->with('success', 'Lesson created successfully.');
    }

    public function editLesson(Course $course, Lesson $lesson)
    {
        return view('admin.lessons.edit', compact('course', 'lesson'));
    }

    public function updateLesson(Request $request, Course $course, Lesson $lesson)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'video_url' => 'nullable|url',
            'duration_minutes' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $lesson->update([
            'title' => $request->title,
            'description' => $request->description,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'video_url' => $request->video_url,
            'duration_minutes' => $request->duration_minutes,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.lessons', $course)->with('success', 'Lesson updated successfully.');
    }

    public function deleteLesson(Course $course, Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->route('admin.lessons', $course)->with('success', 'Lesson deleted successfully.');
    }

    // Analytics
    public function analytics()
    {
        $data = [
            'user_registrations' => User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->where('created_at', '>=', now()->subDays(30))
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
            'course_enrollments' => UserEnrollment::selectRaw('DATE(enrolled_at) as date, COUNT(*) as count')
                ->where('enrolled_at', '>=', now()->subDays(30))
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
            'popular_courses' => Course::withCount('enrollments')
                ->orderBy('enrollments_count', 'desc')
                ->take(10)
                ->get(),
            'completion_rates' => Course::with('enrollments')
                ->get()
                ->map(function ($course) {
                    $total = $course->enrollments->count();
                    $completed = $course->enrollments->where('completed_at', '!=', null)->count();
                    return [
                        'course' => $course->title,
}

return redirect()->route('admin.users')->with('success', 'User updated successfully.');
}

public function deleteUser(User $user)
{
if ($user->is_admin && User::where('is_admin', true)->count() <= 1) {
    return back()->with('error', 'Cannot delete the last admin user.');
}

$user->delete();
return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
}

// Course Management
public function courses()
{
$courses = Course::with('lessons')->paginate(20);
return view('admin.courses.index', compact('courses'));
}

public function createCourse()
{
return view('admin.courses.create');
}

public function storeCourse(Request $request)
{
$request->validate([
    'title' => 'required|string|max:255',
    'description' => 'required|string',
    'level' => 'required|in:beginner,intermediate,advanced',
    'duration_hours' => 'required|integer|min:1',
    'price' => 'required|numeric|min:0',
    'countries' => 'required|array',
    'countries.*' => 'in:in,uk,us,ca,au',
    'image_url' => 'nullable|url',
]);

Course::create([
    'title' => $request->title,
    'description' => $request->description,
    'slug' => Str::slug($request->title),
    'level' => $request->level,
    'duration_hours' => $request->duration_hours,
    'price' => $request->price,
    'countries' => $request->countries,
    'image_url' => $request->image_url,
    'is_active' => true,
    'sort_order' => Course::max('sort_order') + 1,
]);

return redirect()->route('admin.courses')->with('success', 'Course created successfully.');
}

public function editCourse(Course $course)
{
return view('admin.courses.edit', compact('course'));
}

public function updateCourse(Request $request, Course $course)
{
$request->validate([
    'title' => 'required|string|max:255',
    'description' => 'required|string',
    'level' => 'required|in:beginner,intermediate,advanced',
    'duration_hours' => 'required|integer|min:1',
    'price' => 'required|numeric|min:0',
    'countries' => 'required|array',
    'countries.*' => 'in:in,uk,us,ca,au',
    'image_url' => 'nullable|url',
    'is_active' => 'boolean',
]);

$course->update([
    'title' => $request->title,
    'description' => $request->description,
    'slug' => Str::slug($request->title),
    'level' => $request->level,
    'duration_hours' => $request->duration_hours,
    'price' => $request->price,
    'countries' => $request->countries,
    'image_url' => $request->image_url,
    'is_active' => $request->boolean('is_active'),
]);

return redirect()->route('admin.courses')->with('success', 'Course updated successfully.');
}

public function deleteCourse(Course $course)
{
$course->delete();
return redirect()->route('admin.courses')->with('success', 'Course deleted successfully.');
}

// Lesson Management
public function lessons(Course $course)
{
$lessons = $course->lessons()->orderBy('sort_order')->paginate(20);
return view('admin.lessons.index', compact('course', 'lessons'));
}

public function createLesson(Course $course)
{
return view('admin.lessons.create', compact('course'));
}

public function storeLesson(Request $request, Course $course)
{
$request->validate([
    'title' => 'required|string|max:255',
    'description' => 'nullable|string',
    'content' => 'required|string',
    'video_url' => 'nullable|url',
    'duration_minutes' => 'required|integer|min:1',
]);

$course->lessons()->create([
    'title' => $request->title,
    'description' => $request->description,
    'slug' => Str::slug($request->title),
    'content' => $request->content,
    'video_url' => $request->video_url,
    'duration_minutes' => $request->duration_minutes,
    'sort_order' => $course->lessons()->max('sort_order') + 1,
    'is_active' => true,
]);

return redirect()->route('admin.lessons', $course)->with('success', 'Lesson created successfully.');
}

public function editLesson(Course $course, Lesson $lesson)
{
return view('admin.lessons.edit', compact('course', 'lesson'));
}

public function updateLesson(Request $request, Course $course, Lesson $lesson)
{
$request->validate([
    'title' => 'required|string|max:255',
    'description' => 'nullable|string',
    'content' => 'required|string',
    'video_url' => 'nullable|url',
    'duration_minutes' => 'required|integer|min:1',
    'is_active' => 'boolean',
]);

$lesson->update([
    'title' => $request->title,
    'description' => $request->description,
    'slug' => Str::slug($request->title),
    'content' => $request->content,
    'video_url' => $request->video_url,
    'duration_minutes' => $request->duration_minutes,
    'is_active' => $request->boolean('is_active'),
]);

return redirect()->route('admin.lessons', $course)->with('success', 'Lesson updated successfully.');
}

public function deleteLesson(Course $course, Lesson $lesson)
{
$lesson->delete();
return redirect()->route('admin.lessons', $course)->with('success', 'Lesson deleted successfully.');
}

// Analytics
public function analytics()
{
$data = [
    'user_registrations' => User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->where('created_at', '>=', now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date')
        ->get(),
    'course_enrollments' => UserEnrollment::selectRaw('DATE(enrolled_at) as date, COUNT(*) as count')
        ->where('enrolled_at', '>=', now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date')
        ->get(),
    'popular_courses' => Course::withCount('enrollments')
        ->orderBy('enrollments_count', 'desc')
        ->take(10)
        ->get(),
    'completion_rates' => Course::with('enrollments')
        ->get()
        ->map(function ($course) {
            $total = $course->enrollments->count();
            $completed = $course->enrollments->where('completed_at', '!=', null)->count();
            return [
                'course' => $course->title,
                'completion_rate' => $total > 0 ? round(($completed / $total) * 100, 2) : 0,
            ];
        }),
];

return view('admin.analytics', compact('data'));
}

// Course Content Management
public function courseContent($courseId)
{
$course = Course::with(['chapters.quizQuestions'])->findOrFail($courseId);
return view('admin.content.index', compact('course'));
}

public function createChapter($courseId)
{
$course = Course::findOrFail($courseId);
return view('admin.content.create-chapter', compact('course'));
}

public function storeChapter(Request $request, $courseId)
{
$request->validate([
    'title' => 'required|string|max:255',
    'video_id' => 'required|string|max:255',
    'summary' => 'required|array',
    'summary.*' => 'required|string',
    'order_index' => 'required|integer|min:0',
]);

$course = Course::findOrFail($courseId);
    
$chapter = $course->chapters()->create([
    'title' => $request->title,
    'video_id' => $request->video_id,
    'summary' => $request->summary,
    'order_index' => $request->order_index,
    'is_active' => true,
]);

return redirect()->route('admin.course-content', $courseId)
    ->with('success', 'Chapter created successfully!');
}

public function editChapter($courseId, $chapterId)
{
$course = Course::findOrFail($courseId);
$chapter = Chapter::where('course_id', $courseId)->findOrFail($chapterId);
return view('admin.content.edit-chapter', compact('course', 'chapter'));
}

public function updateChapter(Request $request, $courseId, $chapterId)
{
$request->validate([
    'title' => 'required|string|max:255',
    'video_id' => 'required|string|max:255',
    'summary' => 'required|array',
    'summary.*' => 'required|string',
    'order_index' => 'required|integer|min:0',
]);

$chapter = Chapter::where('course_id', $courseId)->findOrFail($chapterId);
    
$chapter->update([
    'title' => $request->title,
    'video_id' => $request->video_id,
    'summary' => $request->summary,
    'order_index' => $request->order_index,
]);

return redirect()->route('admin.course-content', $courseId)
    ->with('success', 'Chapter updated successfully!');
}

public function deleteChapter($courseId, $chapterId)
{
$chapter = Chapter::where('course_id', $courseId)->findOrFail($chapterId);
$chapter->delete();

return redirect()->route('admin.course-content', $courseId)
    ->with('success', 'Chapter deleted successfully!');
}

public function createQuiz($courseId, $chapterId)
{
$course = Course::findOrFail($courseId);
$chapter = Chapter::where('course_id', $courseId)->findOrFail($chapterId);
return view('admin.content.create-quiz', compact('course', 'chapter'));
}

public function storeQuiz(Request $request, $courseId, $chapterId)
{
$request->validate([
    'question' => 'required|string',
    'options' => 'required|array|min:2',
    'options.*' => 'required|string',
    'correct_answer_index' => 'required|integer|min:0',
    'difficulty' => 'required|in:easy,medium,hard',
    'order_index' => 'required|integer|min:0',
]);

$chapter = Chapter::where('course_id', $courseId)->findOrFail($chapterId);
    
$chapter->quizQuestions()->create([
    'question' => $request->question,
    'options' => $request->options,
    'correct_answer_index' => $request->correct_answer_index,
    'difficulty' => $request->difficulty,
    'order_index' => $request->order_index,
    'is_active' => true,
]);

return redirect()->route('admin.course-content', $courseId)
    ->with('success', 'Quiz question created successfully!');
}

public function editQuiz($courseId, $chapterId, $quizId)
{
$course = Course::findOrFail($courseId);
$chapter = Chapter::where('course_id', $courseId)->findOrFail($chapterId);
$quiz = QuizQuestion::where('chapter_id', $chapterId)->findOrFail($quizId);
return view('admin.content.edit-quiz', compact('course', 'chapter', 'quiz'));
}

public function updateQuiz(Request $request, $courseId, $chapterId, $quizId)
{
$request->validate([
    'question' => 'required|string',
    'options' => 'required|array|min:2',
    'options.*' => 'required|string',
    'correct_answer_index' => 'required|integer|min:0',
    'difficulty' => 'required|in:easy,medium,hard',
    'order_index' => 'required|integer|min:0',
]);

$quiz = QuizQuestion::where('chapter_id', $chapterId)->findOrFail($quizId);
    
$quiz->update([
    'question' => $request->question,
    'options' => $request->options,
    'correct_answer_index' => $request->correct_answer_index,
    'difficulty' => $request->difficulty,
    'order_index' => $request->order_index,
]);

return redirect()->route('admin.course-content', $courseId)
    ->with('success', 'Quiz question updated successfully!');
}

public function deleteQuiz($courseId, $chapterId, $quizId)
{
$quiz = QuizQuestion::where('chapter_id', $chapterId)->findOrFail($quizId);
$quiz->delete();

return redirect()->route('admin.course-content', $courseId)
    ->with('success', 'Quiz question deleted successfully!');
}
}
