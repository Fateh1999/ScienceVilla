<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseContentController;

// Country selection landing / authenticated redirect
Route::get('/', function () {
    // If the visitor is already authenticated (session or remember-me cookie),
    // send them straight to their country-scoped home page.
    if (\Illuminate\Support\Facades\Auth::check()) {
        $country = \Illuminate\Support\Facades\Auth::user()->country ?? 'in';
        return redirect()->to("/{$country}");
    }

    // Otherwise show country selector
    return view('country-select');
});

// Auth pages
Route::view('/login', 'auth.login')->name('login')->defaults('country','in');
Route::view('/register', 'auth.register')->name('register')->defaults('country','in');
Route::view('/forgot-password', 'auth.forgot-password')->name('password.request')->defaults('country','in');

// Auth actions
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    
    // Course management
    Route::get('/courses', [AdminController::class, 'courses'])->name('courses');
    Route::get('/courses/create', [AdminController::class, 'createCourse'])->name('courses.create');
    Route::post('/courses', [AdminController::class, 'storeCourse'])->name('courses.store');
    Route::get('/courses/{course}/edit', [AdminController::class, 'editCourse'])->name('courses.edit');
    Route::put('/courses/{course}', [AdminController::class, 'updateCourse'])->name('courses.update');
    Route::delete('/courses/{course}', [AdminController::class, 'deleteCourse'])->name('courses.delete');
    
    // Lesson management
    Route::get('/courses/{course}/lessons', [AdminController::class, 'lessons'])->name('lessons');
    Route::get('/courses/{course}/lessons/create', [AdminController::class, 'createLesson'])->name('lessons.create');
    Route::post('/courses/{course}/lessons', [AdminController::class, 'storeLesson'])->name('lessons.store');
    Route::get('/courses/{course}/lessons/{lesson}/edit', [AdminController::class, 'editLesson'])->name('lessons.edit');
    Route::put('/courses/{course}/lessons/{lesson}', [AdminController::class, 'updateLesson'])->name('lessons.update');
    Route::delete('/courses/{course}/lessons/{lesson}', [AdminController::class, 'deleteLesson'])->name('lessons.delete');
    
    // Analytics
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
    
    // Course Content Management
    Route::get('/courses/{course}/content', [AdminController::class, 'courseContent'])->name('course-content');
    
    // Chapter Management
    Route::get('/courses/{course}/chapters/create', [AdminController::class, 'createChapter'])->name('chapters.create');
    Route::post('/courses/{course}/chapters', [AdminController::class, 'storeChapter'])->name('chapters.store');
    Route::get('/courses/{course}/chapters/{chapter}/edit', [AdminController::class, 'editChapter'])->name('chapters.edit');
    Route::put('/courses/{course}/chapters/{chapter}', [AdminController::class, 'updateChapter'])->name('chapters.update');
    Route::delete('/courses/{course}/chapters/{chapter}', [AdminController::class, 'deleteChapter'])->name('chapters.delete');
    
    // Quiz Management
    Route::get('/courses/{course}/chapters/{chapter}/quiz/create', [AdminController::class, 'createQuiz'])->name('quiz.create');
    Route::post('/courses/{course}/chapters/{chapter}/quiz', [AdminController::class, 'storeQuiz'])->name('quiz.store');
    Route::get('/courses/{course}/chapters/{chapter}/quiz/{quiz}/edit', [AdminController::class, 'editQuiz'])->name('quiz.edit');
    Route::put('/courses/{course}/chapters/{chapter}/quiz/{quiz}', [AdminController::class, 'updateQuiz'])->name('quiz.update');
    Route::delete('/courses/{course}/chapters/{chapter}/quiz/{quiz}', [AdminController::class, 'deleteQuiz'])->name('quiz.delete');
});

// Student routes (authenticated users only)
Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/courses', [StudentController::class, 'courses'])->name('courses');
    Route::get('/browse', [StudentController::class, 'browseCourses'])->name('browse-courses');
    Route::get('/profile', [StudentController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [StudentController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [StudentController::class, 'updateProfile'])->name('profile.update');
    
    // Course enrollment and viewing
    Route::post('/enroll/{course}', [StudentController::class, 'enrollCourse'])->name('enroll');
    Route::get('/course/{course}', [StudentController::class, 'viewCourse'])->name('course.view');
    Route::get('/course/{course}/lesson/{lesson}', [StudentController::class, 'viewLesson'])->name('lesson.view');
    Route::post('/course/{course}/lesson/{lesson}/complete', [StudentController::class, 'markLessonComplete'])->name('lesson.complete');
});

// Redirect root-level courses URL to default country path
Route::redirect('/courses', '/in/courses');

// Serve images via Laravel for static site export
Route::get('/images/{path}', function ($path) {
    $file = public_path("images/{$path}");
    abort_unless(file_exists($file), 404);
    return response()->file($file);
})->where('path', '.*');

// Allowed countries
$countryCodes = 'in|uk|us|ca|au';

Route::group(['prefix'=>'{country}','where'=>['country'=>$countryCodes]], function () {
    Route::get('/', [PageController::class,'home'])->name('home');
    Route::get('/about', [PageController::class,'about'])->name('about');
    Route::get('/courses', [PageController::class,'courses'])->name('courses');
    Route::get('/cocurricular', [PageController::class,'cocurricular'])->name('cocurricular');
    Route::get('/course-detail', [PageController::class,'courseDetail'])->name('course-detail');
    Route::get('/results', [PageController::class,'results'])->name('results');
    Route::get('/gallery', [PageController::class,'gallery'])->name('gallery');
    Route::get('/testimonials', [PageController::class,'testimonials'])->name('testimonials');
    Route::get('/blog', [PageController::class,'blog'])->name('blog');
    Route::get('/contact', [PageController::class,'contact'])->name('contact');
    // Country-scoped auth pages
    Route::view('/login', 'auth.login')->name('login.country');
    Route::view('/register', 'auth.register')->name('register.country');
    Route::view('/forgot-password', 'auth.forgot-password')->name('password.request.country');
    
    // Country-scoped auth actions
    Route::post('/register', [AuthController::class, 'register'])->name('register.country.submit');
    Route::post('/login', [AuthController::class, 'login'])->name('login.country.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout.country');
    
    // Form submission routes
    Route::post('/contact/submit', [ContactController::class, 'submitContact'])->name('contact.submit');
    Route::post('/inquiry/submit', [ContactController::class, 'submitInquiry'])->name('inquiry.submit');
});

// API routes for course content
Route::prefix('api')->group(function () {
    Route::get('/course-content/{slug}', [CourseContentController::class, 'getCourseContent'])->name('api.course-content');
    Route::get('/courses', [CourseContentController::class, 'getAvailableCourses'])->name('api.courses');
});
