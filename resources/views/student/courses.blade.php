@extends('layouts.student')

@section('title', 'My Courses')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">My Courses</h1>
    <p class="text-gray-600">Continue your learning journey with your enrolled courses</p>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
@endif

@if(session('info'))
    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-6">
        {{ session('info') }}
    </div>
@endif

@if($enrolledCourses->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($enrolledCourses as $enrollment)
            <div class="bg-white rounded-lg shadow-sm border hover:shadow-md transition-shadow">
                @if($enrollment->course->image_url)
                    <img src="{{ $enrollment->course->image_url }}" alt="{{ $enrollment->course->title }}" class="w-full h-48 object-cover rounded-t-lg">
                @else
                    <div class="w-full h-48 bg-gradient-to-br from-blue-400 to-blue-600 rounded-t-lg flex items-center justify-center">
                        <i class="bi bi-book text-white text-4xl"></i>
                    </div>
                @endif
                
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $enrollment->course->level == 'beginner' ? 'bg-green-100 text-green-800' : ($enrollment->course->level == 'intermediate' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($enrollment->course->level) }}
                        </span>
                        @if($enrollment->completed_at)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="bi bi-check-circle mr-1"></i>Completed
                            </span>
                        @endif
                    </div>
                    
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $enrollment->course->title }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($enrollment->course->description, 100) }}</p>
                    
                    <div class="mb-4">
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>Progress</span>
                            <span>{{ $enrollment->progress_percentage }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $enrollment->progress_percentage }}%"></div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                        <span><i class="bi bi-play-circle mr-1"></i>{{ $enrollment->course->lessons->count() }} lessons</span>
                        <span><i class="bi bi-clock mr-1"></i>{{ $enrollment->course->duration_hours }}h</span>
                    </div>
                    
                    <div class="flex space-x-2">
                        <a href="{{ route('student.course.view', $enrollment->course) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg font-medium transition-colors">
                            {{ $enrollment->progress_percentage > 0 ? 'Continue' : 'Start Course' }}
                        </a>
                        @if($enrollment->certificate_issued_at)
                            <button class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg font-medium">
                                <i class="bi bi-award"></i>
                            </button>
                        @endif
                    </div>
                    
                    <div class="mt-3 text-xs text-gray-500">
                        Enrolled {{ $enrollment->enrolled_at->diffForHumans() }}
                        @if($enrollment->completed_at)
                            • Completed {{ $enrollment->completed_at->diffForHumans() }}
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    @if($enrolledCourses->hasPages())
        <div class="mt-8">
            {{ $enrolledCourses->links() }}
        </div>
    @endif
@else
    <div class="text-center py-12">
        <div class="max-w-md mx-auto">
            <i class="bi bi-book text-gray-400 text-6xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Courses Yet</h3>
            <p class="text-gray-600 mb-6">You haven't enrolled in any courses yet. Start your learning journey by browsing our available courses.</p>
            <a href="{{ route('student.browse-courses') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium inline-flex items-center">
                <i class="bi bi-search mr-2"></i>Browse Courses
            </a>
        </div>
    </div>
@endif
@endsection
