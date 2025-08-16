@extends('layouts.student')

@section('title', 'Browse Courses')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Browse Courses</h1>
    <p class="text-gray-600">Discover new courses and expand your knowledge</p>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        {{ session('error') }}
    </div>
@endif

@if($courses->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($courses as $course)
            <div class="bg-white rounded-lg shadow-sm border hover:shadow-md transition-shadow">
                @if($course->image_url)
                    <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="w-full h-48 object-cover rounded-t-lg">
                @else
                    <div class="w-full h-48 bg-gradient-to-br from-blue-400 to-blue-600 rounded-t-lg flex items-center justify-center">
                        <i class="bi bi-book text-white text-4xl"></i>
                    </div>
                @endif
                
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $course->level == 'beginner' ? 'bg-green-100 text-green-800' : ($course->level == 'intermediate' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($course->level) }}
                        </span>
                        <span class="text-lg font-bold text-blue-600">${{ number_format($course->price, 2) }}</span>
                    </div>
                    
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $course->title }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($course->description, 100) }}</p>
                    
                    <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                        <span><i class="bi bi-play-circle mr-1"></i>{{ $course->lessons->count() }} lessons</span>
                        <span><i class="bi bi-clock mr-1"></i>{{ $course->duration_hours }}h</span>
                    </div>
                    
                    <div class="flex space-x-2">
                        @if(in_array($course->id, $enrolledCourseIds))
                            <a href="{{ route('student.course.view', $course) }}" class="flex-1 bg-green-600 hover:bg-green-700 text-white text-center py-2 px-4 rounded-lg font-medium transition-colors">
                                <i class="bi bi-check-circle mr-1"></i>Enrolled
                            </a>
                        @else
                            <form action="{{ route('student.enroll', $course) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-medium transition-colors">
                                    Enroll Now
                                </button>
                            </form>
                        @endif
                    </div>
                    
                    <div class="mt-3 text-xs text-gray-500">
                        Available in your region ({{ strtoupper(Auth::user()->country) }})
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    @if($courses->hasPages())
        <div class="mt-8">
            {{ $courses->links() }}
        </div>
    @endif
@else
    <div class="text-center py-12">
        <div class="max-w-md mx-auto">
            <i class="bi bi-search text-gray-400 text-6xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Courses Available</h3>
            <p class="text-gray-600 mb-6">There are currently no courses available in your region. Please check back later or contact support.</p>
        </div>
    </div>
@endif
@endsection
