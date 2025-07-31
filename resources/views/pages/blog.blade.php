@extends('layouts.app')

@section('content')
<section class="relative py-24 bg-gradient-to-br from-purple-50 via-white to-blue-50 overflow-hidden">
    <div class="absolute -top-20 -left-10 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
    <div class="absolute -bottom-20 -right-10 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>

    <div class="container mx-auto px-4">
        <div class="text-center mb-16" data-aos="zoom-in">
            <h2 class="py-2 inline-flex items-center gap-3 justify-center text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent drop-shadow-lg">
                <svg class="w-10 h-10 sm:w-12 sm:h-12 text-purple-600 animate-bounce" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a10 10 0 00-3.162 19.479c.5.092.684-.217.684-.483 0-.237-.009-.866-.013-1.699-2.782.604-3.369-1.342-3.369-1.342-.455-1.156-1.11-1.464-1.11-1.464-.908-.62.069-.608.069-.608 1.004.07 1.532 1.033 1.532 1.033.893 1.531 2.343 1.089 2.915.833.091-.647.349-1.089.636-1.34-2.22-.253-4.555-1.112-4.555-4.954 0-1.094.39-1.989 1.029-2.689-.103-.253-.446-1.27.098-2.646 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.505.338 1.909-1.296 2.748-1.026 2.748-1.026.545 1.376.202 2.393.1 2.646.64.7 1.028 1.595 1.028 2.689 0 3.852-2.338 4.697-4.566 4.945.36.31.68.919.68 1.852 0 1.336-.012 2.414-.012 2.742 0 .268.182.58.688.481A10.002 10.002 0 0012 2z"/></svg>
                <span>ScienceVilla Blog</span>
            </h2>
            <p class="mt-6 text-lg sm:text-xl max-w-3xl mx-auto text-gray-600">Insights, tutorials &amp; study tips carefully curated by our mentors to elevate your learning journey.</p>
        </div>

        @php($posts=[
            ['title'=>'Effective Study Techniques for Board Exams','excerpt'=>'Discover proven methods to maximize your study efficiency and achieve top scores.','image'=>'classroom.jpg','tag'=>'Study Tips','date'=>'Jul 01, 2025'],
            ['title'=>'Fun Science Experiments to Try at Home','excerpt'=>'Hands-on activities that make learning scientific principles engaging and memorable.','image'=>'lab.jpg','tag'=>'Science','date'=>'Jul 06, 2025'],
            ['title'=>'Cracking Competitive Exams: Strategy Guide','excerpt'=>'Roadmap and daily schedules to ace JEE, NEET, and SAT.','image'=>'hero.jpg','tag'=>'Exams','date'=>'Jul 10, 2025'],
            ['title'=>'Math Shortcuts: Lightning-Fast Calculations','excerpt'=>'Learn Vedic math tricks to solve problems in seconds.','image'=>'topper2.jpg','tag'=>'Mathematics','date'=>'Jul 14, 2025'],
            ['title'=>'Choosing the Right Stream After Class 10','excerpt'=>'Commerce, Science, or Arts? We break down each path to help you decide.','image'=>'online.jpg','tag'=>'Career','date'=>'Jul 18, 2025'],
            ['title'=>'Boosting Focus with the Pomodoro Technique','excerpt'=>'A simple time-management method to keep procrastination at bay.','image'=>'featured-bg.jpg','tag'=>'Productivity','date'=>'Jul 22, 2025'],
        ])

        <!-- Blog Grid -->
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3" data-aos="fade-up" data-aos-delay="200">
            @foreach($posts as $p)
            <article class="bg-white rounded-2xl shadow-md overflow-hidden transition-transform duration-300 hover:-translate-y-2 hover:shadow-xl group">
                <div class="relative h-48">
                    <img src="/images/{{ $p['image'] }}" alt="{{ $p['title'] }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                    <span class="absolute top-4 left-4 bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded-full">{{ $p['tag'] }}</span>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-2 text-gray-800 line-clamp-2">{{ $p['title'] }}</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $p['excerpt'] }}</p>
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>{{ $p['date'] }}</span>
                        <a href="#" class="text-blue-600 font-medium hover:underline">Read More →</a>
                    </div>
                    <div class="text-sm text-emerald-600 font-medium">Coming Soon</div>
                </div>
            </article>
            @endforeach
        </div>
        <div class="text-center mt-12">
            <p class="text-gray-600">More blog posts coming soon! Stay tuned for educational content, study guides, and academic insights.</p>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.line-clamp-2{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
.line-clamp-3{display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;}
.animate-blob{animation:blob 7s infinite;}
.animation-delay-2000{animation-delay:2s;}
@keyframes blob{0%,100%{transform:translate(0,0) scale(1);}33%{transform:translate(30px,-20px) scale(1.1);}66%{transform:translate(-20px,20px) scale(0.9);}}
</style>
@endpush
