@extends('layouts.admin')

@section('title', 'Course Management')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Course Management</h1>
        <p class="text-gray-600">Manage all courses and their content</p>
    </div>
    <a href="{{ route('admin.courses.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
        <i class="bi bi-plus-lg mr-2"></i>Add Course
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Level</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lessons</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($courses as $course)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($course->image_url)
                                    <img class="h-10 w-10 rounded-lg object-cover mr-4" src="{{ $course->image_url }}" alt="{{ $course->title }}">
                                @else
                                    <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center mr-4">
                                        <i class="bi bi-book text-gray-500"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $course->title }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($course->description, 50) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $course->level == 'beginner' ? 'bg-green-100 text-green-800' : 
                                   ($course->level == 'intermediate' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($course->level) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $course->duration_hours }}h
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${{ number_format($course->price, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <a href="{{ route('admin.lessons', $course) }}" class="text-blue-600 hover:text-blue-900">
                                {{ $course->lessons->count() }} lessons
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $course->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $course->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.course-content', $course->id) }}" class="text-green-600 hover:text-green-900" title="Manage Course Content">
                                    <i class="bi bi-book-half"></i>
                                </a>
                                <a href="{{ route('admin.lessons', $course) }}" class="text-purple-600 hover:text-purple-900" title="Manage Lessons">
                                    <i class="bi bi-play-circle"></i>
                                </a>
                                <a href="{{ route('admin.courses.edit', $course) }}" class="text-blue-600 hover:text-blue-900" title="Edit Course">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.courses.delete', $course) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this course? This will also delete all associated lessons.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Delete Course">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No courses found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($courses->hasPages())
        <div class="px-6 py-3 border-t">
            {{ $courses->links() }}
        </div>
    @endif
</div>
@endsection
