@extends('layouts.student')

@section('title', 'Student Dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ $user->name }}!</h1>
    <p class="text-gray-600">Track your learning progress and continue your educational journey</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg">
                <i class="bi bi-book text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Enrolled Courses</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_enrollments'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
                <i class="bi bi-check-circle text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Completed Courses</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['completed_courses'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex items-center">
            <div class="p-2 bg-purple-100 rounded-lg">
                <i class="bi bi-play-circle text-purple-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Lessons Completed</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_lessons_completed'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex items-center">
            <div class="p-2 bg-orange-100 rounded-lg">
                <i class="bi bi-clock text-orange-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Study Time</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_study_time'] / 60, 1) }}h</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- My Courses -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="p-6 border-b flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-900">My Courses</h2>
                <a href="{{ route('student.courses') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View All</a>
            </div>
            <div class="p-6">
                @if($enrollments->count() > 0)
                    <div class="space-y-4">
                        @foreach($enrollments->take(3) as $enrollment)
                            <div class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50">
                                <div class="flex items-center">
                                    @if($enrollment->course->image_url)
                                        <img src="{{ $enrollment->course->image_url }}" alt="{{ $enrollment->course->title }}" class="w-12 h-12 rounded-lg object-cover mr-4">
                                    @else
                                        <div class="w-12 h-12 rounded-lg bg-gray-200 flex items-center justify-center mr-4">
                                            <i class="bi bi-book text-gray-500"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="font-medium text-gray-900">{{ $enrollment->course->title }}</h3>
                                        <p class="text-sm text-gray-600">{{ ucfirst($enrollment->course->level) }} • {{ $enrollment->course->lessons->count() }} lessons</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-20 bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">{{ $enrollment->progress_percentage }}%</span>
                                    </div>
                                    <a href="{{ route('student.course.view', $enrollment->course) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium mt-1 block">
                                        Continue Learning
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="bi bi-book text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-500 mb-4">You haven't enrolled in any courses yet</p>
                        <!-- Browse Courses button removed -->
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Activity & Available Courses -->
    <div class="space-y-6">
        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold text-gray-900">Recent Activity</h2>
            </div>
            <div class="p-6">
                @if($recentProgress->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentProgress as $progress)
                            <div class="flex items-center">
                                <div class="p-2 bg-green-100 rounded-lg mr-3">
                                    <i class="bi bi-check-circle text-green-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $progress->lesson->title }}</p>
                                    <p class="text-xs text-gray-600">{{ $progress->lesson->course->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $progress->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">No recent activity</p>
                @endif
            </div>
        </div>

        <!-- Available Courses -->
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="p-6 border-b flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-900">Recommended Courses</h2>
                <a href="{{ route('student.browse-courses') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View All</a>
            </div>
            <div class="p-6">
                @if($availableCourses->count() > 0)
                    <div class="space-y-3">
                        @foreach($availableCourses->take(3) as $course)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    @if($course->image_url)
                                        <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="w-8 h-8 rounded object-cover mr-3">
                                    @else
                                        <div class="w-8 h-8 rounded bg-gray-200 flex items-center justify-center mr-3">
                                            <i class="bi bi-book text-gray-500 text-xs"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $course->title }}</p>
                                        <p class="text-xs text-gray-600">${{ number_format($course->price, 2) }}</p>
                                    </div>
                                </div>
                                <form action="{{ route('student.enroll', $course) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                                        Enroll
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">No courses available for your region</p>
                @endif
            </div>
        </div>
    </div>
</div>

@if($stats['certificates_earned'] > 0)
<!-- Achievements Section -->
<div class="mt-8">
    <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg border border-yellow-200 p-6">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-lg">
                <i class="bi bi-trophy text-yellow-600 text-2xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">Congratulations!</h3>
                <p class="text-gray-600">You've earned {{ $stats['certificates_earned'] }} certificate{{ $stats['certificates_earned'] > 1 ? 's' : '' }}! Keep up the great work.</p>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
