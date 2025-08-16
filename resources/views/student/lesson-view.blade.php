@extends('layouts.student')

@section('title', $lesson->title)

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
                    <a href="{{ route('student.course.view', $course) }}" class="ml-1 text-gray-700 hover:text-blue-600">{{ $course->title }}</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="bi bi-chevron-right text-gray-400"></i>
                    <span class="ml-1 text-gray-500">{{ $lesson->title }}</span>
                </div>
            </li>
        </ol>
    </nav>
</div>

<!-- Lesson Header -->
<div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $lesson->title }}</h1>
            @if($lesson->description)
                <p class="text-gray-600 mt-2">{{ $lesson->description }}</p>
            @endif
        </div>
        
        <div class="flex items-center space-x-4">
            @if($previousLesson)
                <a href="{{ route('student.lesson.view', [$course, $previousLesson->id]) }}" class="flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    <i class="bi bi-chevron-left mr-2"></i>Previous
                </a>
            @endif
            
            @if($nextLesson)
                <a href="{{ route('student.lesson.view', [$course, $nextLesson->id]) }}" class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Next<i class="bi bi-chevron-right ml-2"></i>
                </a>
            @endif
        </div>
    </div>
    
    <div class="flex items-center space-x-6 text-sm text-gray-600">
        <span><i class="bi bi-clock mr-1"></i>{{ $lesson->duration_minutes }} minutes</span>
        @if($lesson->video_url)
            <span><i class="bi bi-play-circle mr-1"></i>Video lesson</span>
        @endif
        @if($progress->completed_at)
            <span class="text-green-600"><i class="bi bi-check-circle mr-1"></i>Completed {{ $progress->completed_at->diffForHumans() }}</span>
        @elseif($progress->progress_percentage > 0)
            <span class="text-blue-600"><i class="bi bi-play-circle mr-1"></i>{{ $progress->progress_percentage }}% complete</span>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-3">
        <!-- Video Section -->
        @if($lesson->video_url)
            <div class="bg-white rounded-lg shadow-sm border mb-6">
                <div class="p-6">
                    <div class="aspect-w-16 aspect-h-9 mb-4">
                        <iframe src="{{ $lesson->video_url }}" class="w-full h-64 rounded-lg" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Lesson Content -->
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="p-6 border-b">
                <h2 class="text-xl font-semibold text-gray-900">Lesson Content</h2>
            </div>
            <div class="p-6">
                <div class="prose max-w-none">
                    {!! nl2br(e($lesson->content)) !!}
                </div>
            </div>
        </div>
        
        <!-- Resources Section -->
        @if($lesson->resources)
            <div class="bg-white rounded-lg shadow-sm border mt-6">
                <div class="p-6 border-b">
                    <h2 class="text-xl font-semibold text-gray-900">Resources</h2>
                </div>
                <div class="p-6">
                    <div class="prose max-w-none">
                        {!! nl2br(e($lesson->resources)) !!}
                    </div>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Sidebar -->
    <div class="lg:col-span-1">
        <!-- Progress Card -->
        <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Progress</h3>
            
            <div class="mb-4">
                <div class="flex justify-between text-sm text-gray-600 mb-2">
                    <span>Lesson Progress</span>
                    <span>{{ $progress->progress_percentage }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $progress->progress_percentage }}%"></div>
                </div>
            </div>
            
            @if(!$progress->completed_at)
                <button onclick="markAsComplete()" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg font-medium transition-colors">
                    <i class="bi bi-check-circle mr-2"></i>Mark as Complete
                </button>
            @else
                <div class="text-center py-2">
                    <i class="bi bi-check-circle text-green-600 text-2xl mb-2"></i>
                    <p class="text-green-600 font-medium">Lesson Completed!</p>
                    <p class="text-sm text-gray-500">{{ $progress->completed_at->diffForHumans() }}</p>
                </div>
            @endif
        </div>
        
        <!-- Course Navigation -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Course Navigation</h3>
            
            <div class="space-y-2">
                <a href="{{ route('student.course.view', $course) }}" class="flex items-center text-blue-600 hover:text-blue-800 text-sm">
                    <i class="bi bi-arrow-left mr-2"></i>Back to Course
                </a>
                
                @if($previousLesson)
                    <a href="{{ route('student.lesson.view', [$course, $previousLesson->id]) }}" class="flex items-center text-gray-600 hover:text-gray-800 text-sm">
                        <i class="bi bi-chevron-left mr-2"></i>{{ Str::limit($previousLesson->title, 25) }}
                    </a>
                @endif
                
                @if($nextLesson)
                    <a href="{{ route('student.lesson.view', [$course, $nextLesson->id]) }}" class="flex items-center text-gray-600 hover:text-gray-800 text-sm">
                        <i class="bi bi-chevron-right mr-2"></i>{{ Str::limit($nextLesson->title, 25) }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function markAsComplete() {
    fetch(`{{ route('student.lesson.complete', [$course, $lesson->id]) }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': window.Laravel.csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to mark lesson as complete. Please try again.');
    });
}
</script>
@endpush
@endsection
