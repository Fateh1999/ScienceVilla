@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
    <p class="text-gray-600">Welcome to the Fateh Science Villa admin panel</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg">
                <i class="bi bi-people text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Users</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
                <i class="bi bi-book text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Courses</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_courses'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex items-center">
            <div class="p-2 bg-purple-100 rounded-lg">
                <i class="bi bi-play-circle text-purple-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Lessons</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_lessons'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border">
        <div class="flex items-center">
            <div class="p-2 bg-orange-100 rounded-lg">
                <i class="bi bi-person-check text-orange-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Enrollments</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_enrollments'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Users -->
    <div class="bg-white rounded-lg shadow-sm border">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-900">Recent Users</h2>
        </div>
        <div class="p-6">
            @if($stats['recent_users']->count() > 0)
                <div class="space-y-4">
                    @foreach($stats['recent_users'] as $user)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $user->email }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">{{ $user->created_at->diffForHumans() }}</p>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $user->is_admin ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $user->is_admin ? 'Admin' : 'User' }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No users yet</p>
            @endif
        </div>
    </div>

    <!-- Recent Enrollments -->
    <div class="bg-white rounded-lg shadow-sm border">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-900">Recent Enrollments</h2>
        </div>
        <div class="p-6">
            @if($stats['recent_enrollments']->count() > 0)
                <div class="space-y-4">
                    @foreach($stats['recent_enrollments'] as $enrollment)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ $enrollment->user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $enrollment->course->title }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">{{ $enrollment->enrolled_at->diffForHumans() }}</p>
                                <div class="w-20 bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No enrollments yet</p>
            @endif
        </div>
    </div>
</div>
@endsection
