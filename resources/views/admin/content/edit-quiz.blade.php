@extends('layouts.admin')

@section('title', 'Edit Quiz Question')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Quiz Question</h1>
            <p class="text-gray-600">{{ $course->title }} - {{ $chapter->title }}</p>
        </div>
        <a href="{{ route('admin.course-content', $course->id) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Back to Course Content
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('admin.quiz.update', [$course->id, $chapter->id, $quiz->id]) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="question" class="block text-sm font-bold text-gray-700 mb-2">Question</label>
                <textarea id="question" 
                          name="question" 
                          rows="3"
                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('question') border-red-500 @enderror"
                          placeholder="Enter the quiz question"
                          required>{{ old('question', $quiz->question) }}</textarea>
                @error('question')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">Answer Options</label>
                <div id="options-container">
                    @php
                        $options = old('options', $quiz->options ?? []);
                    @endphp
                    @foreach($options as $index => $option)
                        <div class="option-item flex mb-2">
                            <input type="text" 
                                   name="options[]" 
                                   value="{{ $option }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2"
                                   placeholder="Enter answer option"
                                   required>
                            <button type="button" onclick="removeOption(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 rounded">
                                Remove
                            </button>
                        </div>
                    @endforeach
                    @if(empty($options))
                        <div class="option-item flex mb-2">
                            <input type="text" 
                                   name="options[]" 
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2"
                                   placeholder="Enter answer option"
                                   required>
                            <button type="button" onclick="removeOption(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 rounded">
                                Remove
                            </button>
                        </div>
                        <div class="option-item flex mb-2">
                            <input type="text" 
                                   name="options[]" 
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2"
                                   placeholder="Enter answer option"
                                   required>
                            <button type="button" onclick="removeOption(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 rounded">
                                Remove
                            </button>
                        </div>
                    @endif
                </div>
                <button type="button" onclick="addOption()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-2">
                    Add Option
                </button>
                @error('options')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="correct_answer_index" class="block text-sm font-bold text-gray-700 mb-2">Correct Answer</label>
                <select id="correct_answer_index" 
                        name="correct_answer_index"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('correct_answer_index') border-red-500 @enderror"
                        required>
                    <option value="">Select the correct answer</option>
                    @foreach($options as $index => $option)
                        <option value="{{ $index }}" {{ old('correct_answer_index', $quiz->correct_answer_index) == $index ? 'selected' : '' }}>
                            Option {{ $index + 1 }}
                        </option>
                    @endforeach
                </select>
                @error('correct_answer_index')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="difficulty" class="block text-sm font-bold text-gray-700 mb-2">Difficulty Level</label>
                <select id="difficulty" 
                        name="difficulty"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('difficulty') border-red-500 @enderror"
                        required>
                    <option value="">Select difficulty level</option>
                    <option value="easy" {{ old('difficulty', $quiz->difficulty) == 'easy' ? 'selected' : '' }}>Easy</option>
                    <option value="medium" {{ old('difficulty', $quiz->difficulty) == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="hard" {{ old('difficulty', $quiz->difficulty) == 'hard' ? 'selected' : '' }}>Hard</option>
                </select>
                @error('difficulty')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="order_index" class="block text-sm font-bold text-gray-700 mb-2">Order Index</label>
                <input type="number" 
                       id="order_index" 
                       name="order_index" 
                       value="{{ old('order_index', $quiz->order_index) }}"
                       min="0"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('order_index') border-red-500 @enderror"
                       required>
                @error('order_index')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-xs mt-1">Lower numbers appear first (0, 1, 2, etc.)</p>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Quiz Question
                </button>
                <a href="{{ route('admin.course-content', $course->id) }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function addOption() {
    const container = document.getElementById('options-container');
    const div = document.createElement('div');
    div.className = 'option-item flex mb-2';
    div.innerHTML = `
        <input type="text" 
               name="options[]" 
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2"
               placeholder="Enter answer option"
               required>
        <button type="button" onclick="removeOption(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 rounded">
            Remove
        </button>
    `;
    container.appendChild(div);
    updateCorrectAnswerOptions();
}

function removeOption(button) {
    const container = document.getElementById('options-container');
    if (container.children.length > 2) {
        button.parentElement.remove();
        updateCorrectAnswerOptions();
    } else {
        alert('At least two answer options are required.');
    }
}

function updateCorrectAnswerOptions() {
    const container = document.getElementById('options-container');
    const select = document.getElementById('correct_answer_index');
    const optionCount = container.children.length;
    const currentValue = select.value;
    
    // Clear existing options except the first one
    select.innerHTML = '<option value="">Select the correct answer</option>';
    
    // Add options based on current option count
    for (let i = 0; i < optionCount; i++) {
        const option = document.createElement('option');
        option.value = i;
        option.textContent = `Option ${i + 1}`;
        if (currentValue == i) {
            option.selected = true;
        }
        select.appendChild(option);
    }
}
</script>
@endsection
