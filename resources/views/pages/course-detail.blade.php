@extends('layouts.app')

@section('content')
<!-- Hero Section (angled banner) -->
<section class="relative bg-emerald-700 text-white">
  <!-- angled background -->
  <div class="absolute inset-0 -skew-y-3 transform origin-top-left bg-gradient-to-r from-emerald-700 via-emerald-600 to-lime-500"></div>
  <div class="relative container mx-auto px-4 py-6 md:py-8 flex flex-col md:flex-row md:items-center gap-4">
      <div class="flex-shrink-0 flex items-center justify-center w-14 h-14 rounded-full bg-white/20 backdrop-blur-md ring-2 ring-white/30">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422A12.083 12.083 0 0118 20.944l-6 3.333-6-3.333A12.083 12.083 0 015.84 10.578L12 14z" />
          </svg>
      </div>
      <div class="flex-1 text-center md:text-left">
          <h1 id="courseName" class="text-3xl md:text-4xl font-extrabold tracking-tight"></h1>
          <p class="text-sm md:text-base mt-1 opacity-90">Master every chapter with crash courses, quizzes & easy summaries.</p>
      </div>
  </div>
</section>

<!-- Main App -->
<div id="courseDetailApp" 
     data-course-slug="{{ request('slug','advanced-physics') }}"
     data-type="{{ request('type', 'course') }}"
     data-activity="{{ request('activity', '') }}"
     class="container mx-auto px-4 py-12">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Sidebar -->
        <aside class="w-full md:w-64 bg-white/80 backdrop-blur-lg rounded-xl shadow-lg p-6 md:sticky top-28 h-max">
            <h2 class="text-xl font-semibold mb-4">Chapters</h2>
            <ul id="chapterList" class="space-y-2 text-sm"></ul>
        </aside>

        <!-- Main Content -->
        <section class="flex-1 bg-white rounded-xl shadow-lg p-6 space-y-6">
            <!-- progress bar -->
<div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden mb-6">
    <div id="progressBar" class="h-full bg-emerald-500 transition-all duration-300" style="width:0%"></div>
</div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                <h2 id="chapterTitle" class="text-2xl font-bold"></h2>
                <div class="flex gap-2">
                    <button id="crashBtn" class="view-btn px-4 py-2 text-sm font-medium rounded-lg border-2 border-blue-400 bg-blue-50 text-blue-700 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200 active" data-view="crash">
                        📚 Crash Course
                    </button>
                    <button id="quizBtn" class="view-btn px-4 py-2 text-sm font-medium rounded-lg border-2 border-purple-400 bg-purple-50 text-purple-700 hover:bg-purple-100 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-colors duration-200" data-view="quiz">
                        🧠 Quiz
                    </button>
                    <button id="summaryBtn" class="view-btn px-4 py-2 text-sm font-medium rounded-lg border-2 border-green-400 bg-green-50 text-green-700 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors duration-200" data-view="summary">
                        📝 Summary
                    </button>
                </div>
            </div>
            <div id="viewContainer"></div>
        </section>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  async function initializeCourse() {
    const app = document.getElementById('courseDetailApp');
    if (!app) {
      console.error('courseDetailApp not found');
      return;
    }
    
    const type = app.dataset.type;
    const activity = app.dataset.activity;
    const slug = app.dataset.courseSlug;
    
    console.log('Type:', type, 'Activity:', activity, 'Slug:', slug);
    
    // Handle cocurricular activities
    if (type === 'cocurricular' && activity) {
      const displayName = decodeURIComponent(activity);
      const courseNameEl = document.getElementById('courseName');
      if (courseNameEl) {
        courseNameEl.textContent = displayName;
      }
      
      // Update subtitle for cocurricular
      const subtitleEl = document.querySelector('.opacity-90');
      if (subtitleEl) {
        subtitleEl.textContent = 'Explore creative skills and personal development through structured activities.';
      }
      
      initializeCocurricularInterface(activity);
      return;
    }
    
    // Regular course handling
    const displayName = slug.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
    const courseNameEl = document.getElementById('courseName');
    if (courseNameEl) {
      courseNameEl.textContent = displayName;
    }

    try {
      const response = await fetch(`/api/course-content/${slug}`);
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      const data = await response.json();
      console.log('Course data for', slug, ':', data);
      
      if (!data || data.length === 0) {
        console.log('No data found for slug:', slug);
        app.innerHTML = '<p class="text-center py-12 text-lg">Content for this course is coming soon. Please check back later.</p>';
        return;
      }
      
      // Initialize the course interface with database data
      initializeCourseInterface(data);
    } catch (error) {
      console.error('Failed to load course content:', error);
      app.innerHTML = '<p class="text-center py-12 text-lg text-red-600">Failed to load course content. Please try again later.</p>';
      return;
    }
  }
  
  function initializeCourseInterface(data) {
    const listEl = document.getElementById('chapterList');
    const viewContainer = document.getElementById('viewContainer');
    const chapterTitleEl = document.getElementById('chapterTitle');
    const viewBtns = document.querySelectorAll('.view-btn');
    let current = 0; // default chapter index
    let currentView = 'crash'; // default view

    // Populate sidebar list
    data.forEach((ch, idx) => {
        const li = document.createElement('li');
        li.textContent = ch.title;
        li.className = 'cursor-pointer px-3 py-2 rounded hover:bg-emerald-100 ' + (idx === 0 ? 'bg-emerald-200 font-semibold' : '');
        li.addEventListener('click', () => {
            current = idx;
            // Update active state
            document.querySelectorAll('#chapterList li').forEach(item => {
                item.className = 'cursor-pointer px-3 py-2 rounded hover:bg-emerald-100';
            });
            li.className = 'cursor-pointer px-3 py-2 rounded hover:bg-emerald-100 bg-emerald-200 font-semibold';
            render();
        });
        listEl.appendChild(li);
    });

    // Add button event listeners
    viewBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active class from all buttons
            viewBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            btn.classList.add('active');
            // Update current view
            currentView = btn.dataset.view;
            render();
        });
    });
    
    function render() {
        const chapter = data[current];
        chapterTitleEl.textContent = chapter.title;
        
        // Update progress bar
        const prog = document.getElementById('progressBar');
        if (prog) {
            const percentage = Math.round(((current + 1) / data.length) * 100);
            prog.style.width = percentage + '%';
        }
        
        const mode = currentView;
        if (mode === 'crash') {
            renderCrashCourse(chapter);
        } else if (mode === 'quiz') {
            renderQuiz(chapter);
        } else if (mode === 'summary') {
            renderSummary(chapter);
        }
    }
    
    function renderCrashCourse(chapter) {
        const videoId = chapter.videoId || 'dQw4w9WgXcQ';
        viewContainer.innerHTML = `
            <div class="aspect-w-16 aspect-h-9 mb-4">
                <iframe class="w-full h-64 md:h-160 rounded-lg" 
                        src="https://www.youtube.com/embed/${videoId}" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                </iframe>
            </div>
            <p class="text-gray-600 text-sm">Watch the crash course video above to learn about ${chapter.title}.</p>
        `;
    }
    
    function renderSummary(chapter) {
        const summaryItems = chapter.summary || [];
        let summaryHtml = '<div class="space-y-4">';
        
        summaryItems.forEach((item, index) => {
            if (typeof item === 'string') {
                summaryHtml += `<div class="flex items-start space-x-3">
                    <span class="flex-shrink-0 w-6 h-6 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-sm font-medium">${index + 1}</span>
                    <p class="text-gray-700">${item}</p>
                </div>`;
            } else if (item.text) {
                summaryHtml += `<div class="flex items-start space-x-3">
                    <span class="flex-shrink-0 w-6 h-6 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-sm font-medium">${index + 1}</span>
                    <div>
                        <p class="text-gray-700">${item.text}</p>
                        ${item.img ? `<img src="${item.img}" alt="Summary illustration" class="mt-2 rounded-lg max-w-sm">` : ''}
                    </div>
                </div>`;
            }
        });
        
        summaryHtml += '</div>';
        viewContainer.innerHTML = summaryHtml;
    }
    
    function renderQuiz(chapter) {
        window.renderQuiz = renderQuiz;
        window.currentChapter = chapter;
        const quizQuestions = chapter.quiz || [];
        if (quizQuestions.length === 0) {
            viewContainer.innerHTML = '<p class="text-center py-8 text-gray-500">No quiz questions available for this chapter.</p>';
            return;
        }
        
        let quizHtml = `
            <div class="mb-6 p-4 bg-emerald-50/60 border border-emerald-200 rounded-lg shadow-sm">
                <label for="difficultySelect" class="block text-sm font-semibold text-gray-700 mb-1">Select Difficulty Level <span class="text-red-500">*</span></label>
                <div class="relative w-52">
                    <select id="difficultySelect" required class="appearance-none w-full bg-white border border-gray-300 rounded-lg px-4 py-2 pr-10 text-sm font-medium text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">

                    <option value="" selected disabled>Select level</option>
                    <option value="easy">📗 Easy</option>
                    <option value="medium">📙 Medium</option>
                    <option value="hard">📕 Hard</option>
                </select>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>
            </div>
            <!-- Enhanced Timer -->
            <div id="timerWrapper" class="mb-4 hidden">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-sm font-semibold text-rose-600"><svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg><span id="timerText">00:00</span></span>
                </div>
                <div class="w-full bg-rose-100 rounded-full h-2">
                    <div id="timerProgress" class="bg-gradient-to-r from-rose-500 via-orange-400 to-yellow-400 h-2 rounded-full transition-all duration-1000 ease-linear" style="width:100%"></div>
                </div>
            </div>
            <div id="quizContent"></div>
            
            <!-- Test Instructions Modal -->
            <div id="testInstructionsModal" class="fixed inset-0 bg-gray-800/30 backdrop-blur-sm flex items-center justify-center z-50 hidden">
                <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 shadow-xl">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Test Instructions</h3>
                    </div>
                    <div class="mb-6 text-sm text-gray-600 space-y-2">
                        <p><strong>📋 Instructions:</strong></p>
                        <ul class="list-disc list-inside space-y-1 ml-2">
                            <li>Read each question carefully before answering</li>
                            <li>Select the best answer from the given options</li>
                            <li>You can review and change answers before submitting</li>
                            <li>Time limit: <span id="timeLimit" class="font-semibold">15 minutes</span></li>
                            <li>Total questions: <span id="totalQuestions" class="font-semibold">5</span></li>
                        </ul>
                        <p class="mt-3"><strong>⚡ Difficulty Level:</strong> <span id="selectedDifficulty" class="font-semibold capitalize"></span></p>
                    </div>
                    <div class="flex gap-3 justify-end">
                        <button id="cancelTest" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition-colors">
                            Cancel
                        </button>
                        <button id="startTest" class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-md hover:bg-emerald-700 transition-colors">
                            Start Test
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        viewContainer.innerHTML = quizHtml;
        
        const modal = document.getElementById('testInstructionsModal');
        const selectedDifficultySpan = document.getElementById('selectedDifficulty');
        const totalQuestionsSpan = document.getElementById('totalQuestions');
        const timeLimitSpan = document.getElementById('timeLimit');
        
        document.getElementById('difficultySelect').addEventListener('change', function() {
            const difficulty = this.value;
            const questions = chapter.quizByDifficulty && chapter.quizByDifficulty[difficulty] 
                ? chapter.quizByDifficulty[difficulty] 
                : quizQuestions.slice(0, 5); // fallback to first 5 questions
            
            // Update modal content
            selectedDifficultySpan.textContent = difficulty;
            totalQuestionsSpan.textContent = questions.length;
            
            // Set time limit based on difficulty
            const timeLimit = difficulty === 'easy' ? '10 minutes' : difficulty === 'medium' ? '15 minutes' : '20 minutes';
            timeLimitSpan.textContent = timeLimit;
            
            // Show modal
            modal.classList.remove('hidden');
            
            // Store questions for later use
            modal.dataset.questions = JSON.stringify(questions);
        });
        
        // Modal event handlers
        document.getElementById('cancelTest').addEventListener('click', function() {
            modal.classList.add('hidden');
            document.getElementById('difficultySelect').value = ''; // Reset dropdown
        });
        
        document.getElementById('startTest').addEventListener('click', function() {
            modal.classList.add('hidden');
            const questions = JSON.parse(modal.dataset.questions);
            renderQuizQuestions(questions);
            // Start countdown timer based on difficulty
            const diff = selectedDifficultySpan.textContent;
            const totalSeconds = diff === 'easy' ? 600 : diff === 'medium' ? 900 : 1200; // 10/15/20 min
            window.currentQuizTotalSeconds = totalSeconds;
            startQuizTimer(totalSeconds);
        
        });
        
        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
                document.getElementById('difficultySelect').value = ''; // Reset dropdown
            }
        });
    }
    
    function renderQuizQuestions(questions) {
        let questionsHtml = '<form id="quizForm"><div class="space-y-6">';
        
        questions.forEach((q, index) => {
            questionsHtml += `<div class="rounded-xl border border-gray-200 shadow-sm p-5 mb-6 bg-gradient-to-br from-white to-stone-50/60">
                <h4 class="font-semibold mb-3 text-gray-800 flex items-start"><span class="inline-flex items-center justify-center w-7 h-7 mr-2 bg-emerald-500 text-white text-xs font-bold rounded-full">${index+1}</span> ${q.q}</h4>
                <div class="grid sm:grid-cols-2 gap-3">`;
            
            q.options.forEach((option, optIndex) => {
                questionsHtml += `
                    <label class="flex items-center bg-white border border-gray-200 rounded-lg p-2 cursor-pointer hover:border-emerald-400 transition-colors">
                        <input type="radio" name="q${index}" value="${optIndex}" class="text-emerald-600 focus:ring-emerald-500 mr-2">
                        <span class="text-gray-700">${option}</span>
                    </label>
                `;
            });
            
            questionsHtml += '</div></div>';
        });
        
        questionsHtml += `
            </div>
            <div class="mt-6 text-center">
                <button type="button" onclick="submitQuiz()" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    Submit Quiz
                </button>
            </div>
            </form>
            
        `;
        
        document.getElementById('quizContent').innerHTML = questionsHtml;
        
        // Store questions for submission
        window.currentQuizQuestions = questions;
    }
    
    // Initialize with first chapter
    render();
  }
  
  // Global function for quiz submission
  let quizTimerInterval;
window.startQuizTimer = function(totalSeconds){
    const wrapper = document.getElementById('timerWrapper');
    const timerText = document.getElementById('timerText');
    const timerProgress = document.getElementById('timerProgress');
    if(!wrapper || !timerText || !timerProgress) return;
    wrapper.classList.remove('hidden');
    let remaining = totalSeconds;
    clearInterval(quizTimerInterval);
    timerText.textContent = formatTime(remaining);
    quizTimerInterval = setInterval(() => {
        remaining--;
        timerText.textContent = formatTime(remaining);
        const percent = Math.round((remaining/totalSeconds)*100);
        timerProgress.style.width = percent + '%';
        if(remaining <= 0){
            clearInterval(quizTimerInterval);
            alert('⏰ Time is up! Your quiz will be submitted automatically.');
            submitQuiz();
        }
    },1000);
    function formatTime(sec){
        const m = Math.floor(sec/60).toString().padStart(2,'0');
        const s = (sec%60).toString().padStart(2,'0');
        return `${m}:${s}`;
    }
};

window.submitQuiz = function() {
    const form = document.getElementById('quizForm');
    const formData = new FormData(form);
    const questions = window.currentQuizQuestions || [];
    
    let score = 0;
    let results = [];
    
    questions.forEach((q, index) => {
        const userAnswer = parseInt(formData.get(`q${index}`));
        const correct = userAnswer === q.ans;
        if (correct) score++;
        
        results.push({
            question: q.q,
            userAnswer: userAnswer !== null ? q.options[userAnswer] : 'Not answered',
            correctAnswer: q.options[q.ans],
            correct: correct
        });
    });
    
    const percentage = Math.round((score / questions.length) * 100);
    
    let resultsHtml = `
        <div class="bg-white border rounded-lg p-6">
            <h3 class="text-xl font-bold mb-4">Quiz Results</h3>
            <div class="mb-4">
                <p class="text-lg">Score: <span class="font-bold ${percentage >= 70 ? 'text-green-600' : 'text-red-600'}">${score}/${questions.length} (${percentage}%)</span></p>
                <p class="text-sm text-gray-600">Grade: <span class="font-medium">${percentage >= 90 ? 'Excellent' : percentage >= 70 ? 'Good' : 'Needs Improvement'}</span></p>
            </div>
            <div class="space-y-3">
    `;
    
    results.forEach((result, index) => {
        resultsHtml += `
            <div class="border-l-4 ${result.correct ? 'border-green-500 bg-green-50' : 'border-red-500 bg-red-50'} p-3">
                <p class="font-medium text-sm">Q${index + 1}. ${result.question}</p>
                <p class="text-sm mt-1">Your answer: <span class="font-medium">${result.userAnswer}</span></p>
                ${!result.correct ? `<p class="text-sm text-green-600">Correct answer: <span class="font-medium">${result.correctAnswer}</span></p>` : ''}
            </div>
        `;
    });
    
    resultsHtml += `</div>
            <div class="text-center mt-6">
                <button id="retakeBtn" type="button" class="px-5 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-400">Retake Quiz</button>
            </div>
        </div>`;
    
    const quizContainer = document.getElementById('quizContent');
    if(quizContainer){
      quizContainer.innerHTML = resultsHtml;
      const rb=document.getElementById('retakeBtn');
      if(rb){ rb.addEventListener('click', retakeQuiz);} 
    }
    const wrap = document.getElementById('timerWrapper');
    if(wrap) wrap.classList.add('hidden');
    clearInterval(quizTimerInterval);
  };

window.retakeQuiz = function(){
    if(window.currentChapter){
        const wrap = document.getElementById('timerWrapper');
        if(wrap) wrap.classList.add('hidden');
        clearInterval(quizTimerInterval);
        renderQuiz(window.currentChapter);
        window.currentQuizTotalSeconds = null;
    }
};

  // Initialize cocurricular activity interface
  function initializeCocurricularInterface(activityName) {
    const listEl = document.getElementById('chapterList');
    const viewContainer = document.getElementById('viewContainer');
    const chapterTitleEl = document.getElementById('chapterTitle');
    const viewBtns = document.querySelectorAll('.view-btn');
    
    // Cocurricular activity data structure
    const cocurricularData = {
      'Drawing Fundamentals': {
        modules: [
          { title: 'Basic Lines & Shapes', content: 'Learn fundamental drawing techniques including line weight, basic shapes, and proportions.' },
          { title: 'Shading Techniques', content: 'Master various shading methods including hatching, cross-hatching, and blending.' },
          { title: 'Perspective Drawing', content: 'Understand one-point and two-point perspective for realistic drawings.' },
          { title: 'Still Life Drawing', content: 'Practice drawing objects from observation with proper lighting and shadows.' }
        ]
      },
      'Sketching & Illustration': {
        modules: [
          { title: 'Gesture Drawing', content: 'Capture movement and energy in quick gesture sketches.' },
          { title: 'Character Design', content: 'Create original characters with unique personalities and features.' },
          { title: 'Environmental Sketching', content: 'Draw landscapes, buildings, and outdoor scenes effectively.' },
          { title: 'Digital Illustration Basics', content: 'Introduction to digital tools and techniques for illustration.' }
        ]
      },
      'Watercolour Painting': {
        modules: [
          { title: 'Color Theory', content: 'Understanding color relationships, temperature, and harmony in painting.' },
          { title: 'Wet-on-Wet Techniques', content: 'Master flowing, organic watercolor effects and blending.' },
          { title: 'Wet-on-Dry Techniques', content: 'Learn controlled, precise watercolor application methods.' },
          { title: 'Landscape Painting', content: 'Paint natural scenes with proper atmospheric perspective.' }
        ]
      },
      'Modern Calligraphy': {
        modules: [
          { title: 'Basic Strokes', content: 'Master fundamental calligraphy strokes and letter formation.' },
          { title: 'Alphabet Styles', content: 'Learn different calligraphy alphabets and their characteristics.' },
          { title: 'Composition & Layout', content: 'Design beautiful layouts and compositions for calligraphy pieces.' },
          { title: 'Advanced Techniques', content: 'Explore flourishing, embellishments, and creative applications.' }
        ]
      }
    };
    
    const activityData = cocurricularData[decodeURIComponent(activityName)] || {
      modules: [
        { title: 'Introduction', content: 'Welcome to this exciting cocurricular activity!' },
        { title: 'Basic Concepts', content: 'Learn the fundamental concepts and techniques.' },
        { title: 'Practice Exercises', content: 'Apply your knowledge through hands-on practice.' },
        { title: 'Final Project', content: 'Create a final project showcasing your skills.' }
      ]
    };
    
    let currentModule = 0;
    
    // Update button labels for cocurricular
    const crashBtn = document.getElementById('crashBtn');
    const quizBtn = document.getElementById('quizBtn');
    const summaryBtn = document.getElementById('summaryBtn');
    
    if (crashBtn) crashBtn.innerHTML = '📚 Learn';
    if (quizBtn) quizBtn.innerHTML = '🎯 Practice';
    if (summaryBtn) summaryBtn.innerHTML = '📝 Summary';
    
    // Populate sidebar with modules
    listEl.innerHTML = '';
    activityData.modules.forEach((module, idx) => {
      const li = document.createElement('li');
      li.textContent = module.title;
      li.className = 'cursor-pointer px-3 py-2 rounded hover:bg-emerald-100 ' + (idx === 0 ? 'bg-emerald-200 font-semibold' : '');
      li.addEventListener('click', () => {
        currentModule = idx;
        document.querySelectorAll('#chapterList li').forEach(item => {
          item.className = 'cursor-pointer px-3 py-2 rounded hover:bg-emerald-100';
        });
        li.className = 'cursor-pointer px-3 py-2 rounded hover:bg-emerald-100 bg-emerald-200 font-semibold';
        renderCocurricularContent();
      });
      listEl.appendChild(li);
    });
    
    // Add button event listeners
    viewBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        viewBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        renderCocurricularContent();
      });
    });
    
    function renderCocurricularContent() {
      const module = activityData.modules[currentModule];
      chapterTitleEl.textContent = module.title;
      
      // Update progress bar
      const prog = document.getElementById('progressBar');
      if (prog) {
        const percentage = Math.round(((currentModule + 1) / activityData.modules.length) * 100);
        prog.style.width = percentage + '%';
      }
      
      const activeBtn = document.querySelector('.view-btn.active');
      const view = activeBtn ? activeBtn.dataset.view : 'crash';
      
      if (view === 'crash') {
        viewContainer.innerHTML = `
          <div class="bg-white border rounded-lg p-6">
            <h3 class="text-xl font-bold mb-4">📚 Learning Content</h3>
            <div class="prose max-w-none">
              <p class="text-gray-700 leading-relaxed">${module.content}</p>
              <div class="mt-6 p-4 bg-blue-50 rounded-lg border-l-4 border-blue-400">
                <h4 class="font-semibold text-blue-800 mb-2">💡 Key Learning Points:</h4>
                <ul class="text-blue-700 space-y-1">
                  <li>• Understand the fundamental concepts</li>
                  <li>• Practice with guided exercises</li>
                  <li>• Apply techniques in creative projects</li>
                  <li>• Build confidence through repetition</li>
                </ul>
              </div>
            </div>
          </div>
        `;
      } else if (view === 'quiz') {
        viewContainer.innerHTML = `
          <div class="bg-white border rounded-lg p-6">
            <h3 class="text-xl font-bold mb-4">🎯 Practice Activity</h3>
            <div class="space-y-4">
              <p class="text-gray-700">Practice what you've learned in <strong>${module.title}</strong>:</p>
              <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <h4 class="font-semibold text-yellow-800 mb-2">📝 Practice Exercise:</h4>
                <p class="text-yellow-700">Complete the hands-on activity related to ${module.title.toLowerCase()}. Take your time and focus on applying the techniques you've learned.</p>
              </div>
              <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <h4 class="font-semibold text-green-800 mb-2">✅ Success Criteria:</h4>
                <ul class="text-green-700 space-y-1">
                  <li>• Demonstrate understanding of key concepts</li>
                  <li>• Apply techniques correctly</li>
                  <li>• Show creativity and personal style</li>
                  <li>• Complete the activity within the timeframe</li>
                </ul>
              </div>
            </div>
          </div>
        `;
      } else if (view === 'summary') {
        viewContainer.innerHTML = `
          <div class="bg-white border rounded-lg p-6">
            <h3 class="text-xl font-bold mb-4">📝 Module Summary</h3>
            <div class="space-y-4">
              <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-semibold mb-2">📋 What You Learned:</h4>
                <p class="text-gray-700">${module.content}</p>
              </div>
              <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                <h4 class="font-semibold text-purple-800 mb-2">🎯 Next Steps:</h4>
                <p class="text-purple-700">Continue practicing these techniques and move on to the next module when you feel confident with the current concepts.</p>
              </div>
            </div>
          </div>
        `;
      }
    }
    
    // Initial render
    renderCocurricularContent();
  }
    
   // Start the initialization
  initializeCourse();
});
</script>
@endsection
