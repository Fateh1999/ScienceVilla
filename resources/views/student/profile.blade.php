@extends('layouts.student')

@section('title', 'My Profile')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
    <p class="text-gray-600">Manage your account and view your learning statistics</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Profile Information -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Profile Information</h2>
                <a href="{{ route('student.profile.edit') }}" class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">Edit</a>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Full Name</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email Address</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Country</label>
                    <p class="mt-1 text-sm text-gray-900">
                        @switch($user->country)
                            @case('in') India @break
                            @case('uk') United Kingdom @break
                            @case('us') United States @break
                            @case('ca') Canada @break
                            @case('au') Australia @break
                            @default {{ strtoupper($user->country) }}
                        @endswitch
                    </p>
                </div>
                
                @if($user->dob)
                <div>
                    <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                    <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($user->dob)->format('M d, Y') }}</p>
                </div>
                @endif
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Member Since</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('M d, Y') }}</p>
                </div>
                
                @if($user->last_login_at)
                <div>
                    <label class="block text-sm font-medium text-gray-700">Last Login</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $user->last_login_at->diffForHumans() }}</p>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Learning Statistics -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Learning Statistics</h2>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600">{{ $stats['total_enrollments'] }}</div>
                    <div class="text-sm text-gray-600">Total Enrollments</div>
                </div>
                
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <div class="text-2xl font-bold text-green-600">{{ $stats['completed_courses'] }}</div>
                    <div class="text-sm text-gray-600">Completed Courses</div>
                </div>
                
                <div class="text-center p-4 bg-purple-50 rounded-lg">
                    <div class="text-2xl font-bold text-purple-600">{{ $stats['certificates_earned'] }}</div>
                    <div class="text-sm text-gray-600">Certificates Earned</div>
                </div>
                
                <div class="text-center p-4 bg-orange-50 rounded-lg">
                    <div class="text-2xl font-bold text-orange-600">{{ number_format($stats['total_study_time'] / 60, 1) }}h</div>
                    <div class="text-sm text-gray-600">Total Study Time</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="space-y-6">
        <!-- Profile Picture -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Profile Picture</h3>
            <div class="text-center">
                <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-person text-gray-500 text-3xl"></i>
                </div>
                <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Upload Photo
                </button>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('student.browse-courses') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                    <i class="bi bi-search mr-3"></i>Browse New Courses
                </a>
                <a href="{{ route('student.courses') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                    <i class="bi bi-book mr-3"></i>Continue Learning
                </a>
                <button class="flex items-center text-blue-600 hover:text-blue-800">
                    <i class="bi bi-gear mr-3"></i>Account Settings
                </button>
                <button class="flex items-center text-blue-600 hover:text-blue-800">
                    <i class="bi bi-download mr-3"></i>Download Certificates
                </button>
            </div>
        </div>
        
        <!-- Achievement Badge -->
        @if($stats['completed_courses'] > 0)
        <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg border border-yellow-200 p-6">
            <div class="text-center">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="bi bi-trophy text-yellow-600 text-2xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">Course Completer</h3>
                <p class="text-sm text-gray-600">You've completed {{ $stats['completed_courses'] }} course{{ $stats['completed_courses'] > 1 ? 's' : '' }}!</p>
            </div>
        </div>
        @endif
        
        @if($stats['total_study_time'] > 600) <!-- 10+ hours -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200 p-6">
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="bi bi-clock text-blue-600 text-2xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">Dedicated Learner</h3>
                <p class="text-sm text-gray-600">{{ number_format($stats['total_study_time'] / 60, 1) }} hours of learning!</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
