@extends('layouts.student')

@section('title', $course->title)

@section('content')
<div class="mb-6">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('student.courses') }}" class="text-gray-700 hover:text-blue-600">My Courses</a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="bi bi-chevron-right text-gray-400"></i>
                    <span class="ml-1 text-gray-500">{{ $course->title }}</span>
                </div>
            </li>
        </ol>
    </nav>
</div>

<!-- Course Header -->
<div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <div class="flex items-center space-x-3 mb-4">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $course->level == 'beginner' ? 'bg-green-100 text-green-800' : ($course->level == 'intermediate' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                    {{ ucfirst($course->level) }}
                </span>
                @if($enrollment->completed_at)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <i class="bi bi-check-circle mr-1"></i>Completed
                    </span>
                @endif
            </div>
            
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $course->title }}</h1>
            <p class="text-gray-600 mb-4">{{ $course->description }}</p>
            
            <div class="flex items-center space-x-6 text-sm text-gray-600">
                <span><i class="bi bi-play-circle mr-1"></i>{{ $lessons->count() }} lessons</span>
                <span><i class="bi bi-clock mr-1"></i>{{ $course->duration_hours }} hours</span>
                <span><i class="bi bi-calendar mr-1"></i>Enrolled {{ $enrollment->enrolled_at->diffForHumans() }}</span>
            </div>
        </div>
        
        @if($course->image_url)
            <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="w-32 h-32 rounded-lg object-cover ml-6">
        @endif
    </div>
    
    <!-- Progress Bar -->
    <div class="mt-6">
        <div class="flex justify-between text-sm text-gray-600 mb-2">
            <span>Course Progress</span>
            <span>{{ $enrollment->progress_percentage }}% Complete</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div class="bg-blue-600 h-3 rounded-full transition-all duration-300" style="width: {{ $enrollment->progress_percentage }}%"></div>
        </div>
    </div>
</div>

<!-- Course Content -->
<div class="bg-white rounded-lg shadow-sm border">
    <div class="p-6 border-b">
        <h2 class="text-xl font-semibold text-gray-900">Course Content</h2>
    </div>
    
    <div class="divide-y divide-gray-200">
        @foreach($lessons as $index => $lesson)
            <div class="p-6 hover:bg-gray-50 transition-colors">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 mr-4">
                            @if($lesson->user_progress && $lesson->user_progress->completed_at)
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="bi bi-check-circle text-green-600"></i>
                                </div>
                            @elseif($lesson->user_progress && $lesson->user_progress->progress_percentage > 0)
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="bi bi-play-circle text-blue-600"></i>
                                </div>
                            @else
                                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                    <span class="text-gray-600 text-sm font-medium">{{ $index + 1 }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex-1">
                            <h3 class="text-lg font-medium text-gray-900">{{ $lesson->title }}</h3>
                            @if($lesson->description)
                                <p class="text-gray-600 text-sm mt-1">{{ $lesson->description }}</p>
                            @endif
                            <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                                <span><i class="bi bi-clock mr-1"></i>{{ $lesson->duration_minutes }} min</span>
                                @if($lesson->video_url)
                                    <span><i class="bi bi-play-circle mr-1"></i>Video</span>
                                @endif
                                @if($lesson->user_progress && $lesson->user_progress->completed_at)
                                    <span class="text-green-600"><i class="bi bi-check-circle mr-1"></i>Completed {{ $lesson->user_progress->completed_at->diffForHumans() }}</span>
                                @elseif($lesson->user_progress && $lesson->user_progress->progress_percentage > 0)
                                    <span class="text-blue-600"><i class="bi bi-play-circle mr-1"></i>{{ $lesson->user_progress->progress_percentage }}% complete</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        @if($lesson->user_progress && $lesson->user_progress->completed_at)
                            <a href="{{ route('student.lesson.view', [$course, $lesson->id]) }}" class="text-green-600 hover:text-green-800 font-medium">
                                Review
                            </a>
                        @else
                            <a href="{{ route('student.lesson.view', [$course, $lesson->id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                                {{ $lesson->user_progress && $lesson->user_progress->progress_percentage > 0 ? 'Continue' : 'Start' }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@if($enrollment->completed_at)
    <!-- Certificate Section -->
    <div class="mt-6 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg border border-yellow-200 p-6">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-lg">
                <i class="bi bi-trophy text-yellow-600 text-2xl"></i>
            </div>
            <div class="ml-4 flex-1">
                <h3 class="text-lg font-semibold text-gray-900">Course Completed!</h3>
                <p class="text-gray-600">Congratulations! You completed this course on {{ $enrollment->completed_at->format('M d, Y') }}.</p>
                @if($enrollment->certificate_issued_at)
                    <p class="text-sm text-gray-500 mt-1">Certificate issued {{ $enrollment->certificate_issued_at->diffForHumans() }}</p>
                @endif
            </div>
            @if($enrollment->certificate_issued_at)
                <button class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-medium">
                    <i class="bi bi-download mr-2"></i>Download Certificate
                </button>
            @endif
        </div>
    </div>
@endif
@endsection
