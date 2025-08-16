@extends('layouts.admin')

@section('title', 'Course Content - ' . $course->title)

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Course Content</h1>
            <p class="text-gray-600">{{ $course->title }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.courses') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Courses
            </a>
            <a href="{{ route('admin.chapters.create', $course->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add Chapter
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($course->chapters->count() > 0)
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            @foreach($course->chapters->sortBy('order_index') as $chapter)
                <div class="border-b border-gray-200 last:border-b-0">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                    {{ $chapter->title }}
                                    <span class="text-sm text-gray-500 font-normal">(Order: {{ $chapter->order_index }})</span>
                                </h3>
                                <p class="text-gray-600 mb-3">Video ID: {{ $chapter->video_id }}</p>
                                
                                <div class="mb-4">
                                    <h4 class="font-medium text-gray-800 mb-2">Summary Points:</h4>
                                    <ul class="list-disc list-inside text-gray-600 space-y-1">
                                        @foreach($chapter->summary as $point)
                                            @if(is_string($point))
                                                <li>{{ $point }}</li>
                                            @elseif(is_array($point) && isset($point['text']))
                                                <li>{{ $point['text'] }} @if(!empty($point['img']))<span class="text-blue-500">(with image)</span>@endif</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="mb-4">
                                    <h4 class="font-medium text-gray-800 mb-2">Quiz Questions: {{ $chapter->quizQuestions->count() }}</h4>
                                    @if($chapter->quizQuestions->count() > 0)
                                        <div class="grid grid-cols-3 gap-2 text-sm">
                                            <div class="bg-green-100 p-2 rounded text-center">
                                                <span class="font-medium">Easy:</span> {{ $chapter->quizQuestions->where('difficulty', 'easy')->count() }}
                                            </div>
                                            <div class="bg-yellow-100 p-2 rounded text-center">
                                                <span class="font-medium">Medium:</span> {{ $chapter->quizQuestions->where('difficulty', 'medium')->count() }}
                                            </div>
                                            <div class="bg-red-100 p-2 rounded text-center">
                                                <span class="font-medium">Hard:</span> {{ $chapter->quizQuestions->where('difficulty', 'hard')->count() }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="flex flex-col space-y-2 ml-4">
                                <a href="{{ route('admin.chapters.edit', [$course->id, $chapter->id]) }}" 
                                   class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm">
                                    Edit Chapter
                                </a>
                                <a href="{{ route('admin.quiz.create', [$course->id, $chapter->id]) }}" 
                                   class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">
                                    Add Quiz
                                </a>
                                <form action="{{ route('admin.chapters.delete', [$course->id, $chapter->id]) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm w-full"
                                            onclick="return confirm('Are you sure you want to delete this chapter?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>

                        @if($chapter->quizQuestions->count() > 0)
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <h5 class="font-medium text-gray-800 mb-3">Quiz Questions:</h5>
                                <div class="space-y-2">
                                    @foreach($chapter->quizQuestions->sortBy('order_index') as $quiz)
                                        <div class="flex justify-between items-center bg-gray-50 p-3 rounded">
                                            <div class="flex-1">
                                                <p class="text-sm font-medium">{{ Str::limit($quiz->question, 80) }}</p>
                                                <p class="text-xs text-gray-500">
                                                    Difficulty: {{ ucfirst($quiz->difficulty) }} | 
                                                    Options: {{ count($quiz->options) }} | 
                                                    Order: {{ $quiz->order_index }}
                                                </p>
                                            </div>
                                            <div class="flex space-x-1">
                                                <a href="{{ route('admin.quiz.edit', [$course->id, $chapter->id, $quiz->id]) }}" 
                                                   class="bg-yellow-400 hover:bg-yellow-600 text-white text-xs py-1 px-2 rounded">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.quiz.delete', [$course->id, $chapter->id, $quiz->id]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="bg-red-400 hover:bg-red-600 text-white text-xs py-1 px-2 rounded"
                                                            onclick="return confirm('Are you sure?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white shadow-md rounded-lg p-8 text-center">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">No Chapters Yet</h3>
            <p class="text-gray-600 mb-6">This course doesn't have any chapters yet. Add your first chapter to get started.</p>
            <a href="{{ route('admin.chapters.create', $course->id) }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add First Chapter
            </a>
        </div>
    @endif
</div>
@endsection
