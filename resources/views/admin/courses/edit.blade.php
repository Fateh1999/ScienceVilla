@extends('layouts.admin')

@section('title', 'Edit Course')

@section('content')
<div class="mb-6">
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.courses') }}" class="text-gray-600 hover:text-gray-900">
            <i class="bi bi-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Course</h1>
            <p class="text-gray-600">Update course information</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm border p-6">
    <form action="{{ route('admin.courses.update', $course) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Course Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $course->title) }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $course->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="level" class="block text-sm font-medium text-gray-700 mb-2">Level</label>
                <select id="level" name="level" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('level') border-red-500 @enderror">
                    <option value="">Select Level</option>
                    <option value="beginner" {{ old('level', $course->level) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                    <option value="intermediate" {{ old('level', $course->level) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                    <option value="advanced" {{ old('level', $course->level) == 'advanced' ? 'selected' : '' }}>Advanced</option>
                </select>
                @error('level')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="duration_hours" class="block text-sm font-medium text-gray-700 mb-2">Duration (Hours)</label>
                <input type="number" id="duration_hours" name="duration_hours" value="{{ old('duration_hours', $course->duration_hours) }}" min="1"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('duration_hours') border-red-500 @enderror">
                @error('duration_hours')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price ($)</label>
                <input type="number" id="price" name="price" value="{{ old('price', $course->price) }}" min="0" step="0.01"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('price') border-red-500 @enderror">
                @error('price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="image_url" class="block text-sm font-medium text-gray-700 mb-2">Image URL (Optional)</label>
                <input type="url" id="image_url" name="image_url" value="{{ old('image_url', $course->image_url) }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('image_url') border-red-500 @enderror">
                @error('image_url')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Available Countries</label>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <div class="flex items-center">
                    <input type="checkbox" id="country_in" name="countries[]" value="in" {{ in_array('in', old('countries', $course->countries ?? [])) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="country_in" class="ml-2 block text-sm text-gray-900">India</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="country_uk" name="countries[]" value="uk" {{ in_array('uk', old('countries', $course->countries ?? [])) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="country_uk" class="ml-2 block text-sm text-gray-900">United Kingdom</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="country_us" name="countries[]" value="us" {{ in_array('us', old('countries', $course->countries ?? [])) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="country_us" class="ml-2 block text-sm text-gray-900">United States</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="country_ca" name="countries[]" value="ca" {{ in_array('ca', old('countries', $course->countries ?? [])) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="country_ca" class="ml-2 block text-sm text-gray-900">Canada</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="country_au" name="countries[]" value="au" {{ in_array('au', old('countries', $course->countries ?? [])) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="country_au" class="ml-2 block text-sm text-gray-900">Australia</label>
                </div>
            </div>
            @error('countries')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-6">
            <div class="flex items-center">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $course->is_active) ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="is_active" class="ml-2 block text-sm text-gray-900">
                    Course is active
                </label>
            </div>
            <p class="text-sm text-gray-500 mt-1">Inactive courses will not be visible to students</p>
        </div>

        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.courses') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Update Course
            </button>
        </div>
    </form>
</div>
@endsection
