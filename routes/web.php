<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;

// Country selection landing page
Route::get('/', function () {
    return view('country-select');
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
    Route::get('/course-detail', [PageController::class,'courseDetail'])->name('course-detail');
    Route::get('/results', [PageController::class,'results'])->name('results');
    Route::get('/gallery', [PageController::class,'gallery'])->name('gallery');
    Route::get('/testimonials', [PageController::class,'testimonials'])->name('testimonials');
    Route::get('/blog', [PageController::class,'blog'])->name('blog');
    Route::get('/contact', [PageController::class,'contact'])->name('contact');
    
    // Form submission routes
    Route::post('/contact/submit', [ContactController::class, 'submitContact'])->name('contact.submit');
    Route::post('/inquiry/submit', [ContactController::class, 'submitInquiry'])->name('inquiry.submit');
});
