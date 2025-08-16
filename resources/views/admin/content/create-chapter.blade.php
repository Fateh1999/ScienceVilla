@extends('layouts.admin')

@section('title', 'Add Chapter - ' . $course->title)

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Add New Chapter</h1>
            <p class="text-gray-600">{{ $course->title }}</p>
        </div>
        <a href="{{ route('admin.course-content', $course->id) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Back to Course Content
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('admin.chapters.store', $course->id) }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Chapter Title</label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror"
                       placeholder="Enter chapter title"
                       required>
                @error('title')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="video_id" class="block text-sm font-bold text-gray-700 mb-2">YouTube Video ID</label>
                <input type="text" 
                       id="video_id" 
                       name="video_id" 
                       value="{{ old('video_id') }}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('video_id') border-red-500 @enderror"
                       placeholder="e.g., dQw4w9WgXcQ"
                       pattern="[a-zA-Z0-9_-]{11}"
                       title="YouTube video ID should be 11 characters long and contain only letters, numbers, underscores, and hyphens"
                       required>
                @error('video_id')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
                <div class="text-gray-500 text-xs mt-1">
                    <p><strong>Enter ONLY the video ID</strong> (11 characters), not the full URL.</p>
                    <p>Example: From <code>https://www.youtube.com/watch?v=dQw4w9WgXcQ</code> → use <code>dQw4w9WgXcQ</code></p>
                    <p class="text-red-600">❌ Don't include: &list=, &index=, or other URL parameters</p>
                </div>
            </div>

            <div class="mb-4">
                <label for="order_index" class="block text-sm font-bold text-gray-700 mb-2">Order Index</label>
                <input type="number" 
                       id="order_index" 
                       name="order_index" 
                       value="{{ old('order_index', 0) }}"
                       min="0"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('order_index') border-red-500 @enderror"
                       required>
                @error('order_index')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-xs mt-1">Lower numbers appear first (0, 1, 2, etc.)</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Summary Points</label>
                <div id="summary-container">
                    @if(old('summary'))
                        @foreach(old('summary') as $index => $point)
                            <div class="summary-item flex mb-2">
                                <input type="text" 
                                       name="summary[]" 
                                       value="{{ $point }}"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2"
                                       placeholder="Enter summary point"
                                       required>
                                <button type="button" onclick="removeSummaryItem(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 rounded">
                                    Remove
                                </button>
                            </div>
                        @endforeach
                    @else
                        <div class="summary-item flex mb-2">
                            <input type="text" 
                                   name="summary[]" 
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2"
                                   placeholder="Enter summary point"
                                   required>
                            <button type="button" onclick="removeSummaryItem(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 rounded">
                                Remove
                            </button>
                        </div>
                    @endif
                </div>
                <button type="button" onclick="addSummaryItem()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-2">
                    Add Summary Point
                </button>
                @error('summary')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Create Chapter
                </button>
                <a href="{{ route('admin.course-content', $course->id) }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function addSummaryItem() {
    const container = document.getElementById('summary-container');
    const div = document.createElement('div');
    div.className = 'summary-item flex mb-2';
    div.innerHTML = `
        <input type="text" 
               name="summary[]" 
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2"
               placeholder="Enter summary point"
               required>
        <button type="button" onclick="removeSummaryItem(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 rounded">
            Remove
        </button>
    `;
    container.appendChild(div);
}

function removeSummaryItem(button) {
    const container = document.getElementById('summary-container');
    if (container.children.length > 1) {
        button.parentElement.remove();
    } else {
        alert('At least one summary point is required.');
    }
}
</script>
@endsection
