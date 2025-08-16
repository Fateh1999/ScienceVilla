@extends('layouts.admin')

@section('title', 'Lesson Management')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.courses') }}" class="text-gray-600 hover:text-gray-900">
                <i class="bi bi-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $course->title }} - Lessons</h1>
                <p class="text-gray-600">Manage lessons for this course</p>
            </div>
        </div>
    </div>
    <a href="{{ route('admin.lessons.create', $course) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
        <i class="bi bi-plus-lg mr-2"></i>Add Lesson
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-lg shadow-sm border">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lesson</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Video</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($lessons as $lesson)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $lesson->title }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($lesson->description, 50) }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $lesson->duration_minutes }}min
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($lesson->video_url)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="bi bi-play-circle mr-1"></i>Video
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Text Only
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $lesson->sort_order }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $lesson->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $lesson->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.lessons.edit', [$course, $lesson]) }}" class="text-blue-600 hover:text-blue-900" title="Edit Lesson">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.lessons.delete', [$course, $lesson]) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this lesson?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Delete Lesson">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No lessons found for this course
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($lessons->hasPages())
        <div class="px-6 py-3 border-t">
            {{ $lessons->links() }}
        </div>
    @endif
</div>
@endsection
