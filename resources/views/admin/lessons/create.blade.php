@extends('layouts.admin')

@section('title', 'Create Lesson')

@section('content')
<div class="mb-6">
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.lessons', $course) }}" class="text-gray-600 hover:text-gray-900">
            <i class="bi bi-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Create Lesson</h1>
            <p class="text-gray-600">Add a new lesson to {{ $course->title }}</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm border p-6">
    <form action="{{ route('admin.lessons.store', $course) }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Lesson Title</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                <textarea id="description" name="description" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="duration_minutes" class="block text-sm font-medium text-gray-700 mb-2">Duration (Minutes)</label>
                <input type="number" id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes') }}" min="1"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('duration_minutes') border-red-500 @enderror">
                @error('duration_minutes')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="video_url" class="block text-sm font-medium text-gray-700 mb-2">Video URL (Optional)</label>
                <input type="url" id="video_url" name="video_url" value="{{ old('video_url') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('video_url') border-red-500 @enderror">
                @error('video_url')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6">
            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Lesson Content</label>
            <textarea id="content" name="content" rows="12" 
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
            <p class="text-sm text-gray-500 mt-1">You can use HTML tags for formatting</p>
            @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.lessons', $course) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Create Lesson
            </button>
        </div>
    </form>
</div>
@endsection
