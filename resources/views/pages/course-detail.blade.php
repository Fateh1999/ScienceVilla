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
<div id="courseDetailApp" data-course-slug="{{ request('slug','class-8-maths-icse') }}" class="container mx-auto px-4 py-12">
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
                <select id="viewSelect" class="w-40 text-sm h-9 border border-emerald-400 bg-emerald-50/60 rounded-md px-3 focus:outline-none focus:ring-2 focus:ring-emerald-600 shadow-inner">
                    <option value="crash">Crash Course</option>
                    <option value="quiz">Quiz</option>
                    <option value="summary">Summary</option>
                </select>
            </div>
            <div id="viewContainer"></div>
        </section>
    </div>
</div>

<script src="{{ asset('js/course-content.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Wait for course-content.js to load
  function initializeCourse() {
    const app = document.getElementById('courseDetailApp');
    if (!app) {
      console.error('courseDetailApp not found');
      return;
    }
    
    const slug = app.dataset.courseSlug;
    console.log('Course slug:', slug);
    console.log('Available courses:', window.COURSE_CONTENT ? Object.keys(window.COURSE_CONTENT) : 'COURSE_CONTENT not loaded');
    
    if (!window.COURSE_CONTENT) {
      console.error('COURSE_CONTENT not loaded, retrying in 100ms...');
      setTimeout(initializeCourse, 100);
      return;
    }
    
    const displayName = slug.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
    const courseNameEl = document.getElementById('courseName');
    if (courseNameEl) {
      courseNameEl.textContent = displayName;
    }

    const data = window.COURSE_CONTENT[slug];
    console.log('Course data for', slug, ':', data);
    
    if (!data || data.length === 0) {
      console.log('No data found for slug:', slug);
      app.innerHTML = '<p class="text-center py-12 text-lg">Content for this course is coming soon. Please check back later.</p>';
      return;
    }



    const listEl = document.getElementById('chapterList');
    
    const viewSel = document.getElementById('viewSelect');
    const viewContainer = document.getElementById('viewContainer');
    const chapterTitleEl = document.getElementById('chapterTitle');
    let current = 0; // default chapter index

    // Populate sidebar list
    data.forEach((ch,idx)=>{
        const li = document.createElement('li');
        li.textContent = ch.title;
        li.className = 'cursor-pointer px-3 py-2 rounded hover:bg-emerald-100 ' + (idx===0?'bg-emerald-200 font-semibold':'');
        li.addEventListener('click', ()=>{
            current = idx;
            document.querySelectorAll('#chapterList li').forEach(el=>el.classList.remove('bg-emerald-200','font-semibold'));
            li.classList.add('bg-emerald-200','font-semibold');
            render();
        });
        listEl.appendChild(li);
    });

    viewSel.addEventListener('change', render);
    
    let quizTimer = null;
    let quizStartTime = null;
    let quizTimeLimit = 300; // 5 minutes in seconds

    function render(){
        const chapter = data[current];
        chapterTitleEl.textContent = chapter.title;
        // update progress bar
        const prog = document.getElementById('progressBar');
        if(prog){
            prog.style.width = `${Math.round(((current+1)/data.length)*100)}%`;
        }
        
        const mode = viewSel.value;
        if(mode==='crash'){
            clearQuizTimer();
            viewContainer.innerHTML = `<div class="aspect-video"><iframe class="w-full h-full rounded" src="https://www.youtube.com/embed/${chapter.videoId}" frameborder="0" allowfullscreen></iframe></div>`;
        }else if(mode==='quiz'){
            renderQuiz(chapter);
        }else if(mode==='summary'){
            clearQuizTimer();
            // function to download PDF summary for this chapter
            window.downloadSummary = async function() {
              const items = chapter.summary.map(s => (typeof s === 'object' ? s : { text: s }));
              const slug = chapter.title.replace(/\s+/g,'-').toLowerCase();
              const triggerPdf = async () => {
                const { jsPDF } = window.jspdf || window;
                const doc = new jsPDF();
                
                // Add title with emerald styling
                doc.setFontSize(18);
                doc.setTextColor(16, 185, 129); // emerald-500
                doc.text(chapter.title, 105, 20, { align: 'center' });
                
                // Add border-like line
                doc.setDrawColor(16, 185, 129);
                doc.line(20, 25, 190, 25);
                
                let y = 40;
                doc.setFontSize(12);
                doc.setTextColor(55, 65, 81); // gray-700
                
                for (const itm of items) {
                  // card bg
                  doc.setFillColor(236, 253, 245);
                  // calculate card height dynamically
                  let cardHeight = 15;
                  let imgHeight = 0;
                  if(itm.img){
                     try{
                       // Convert relative URL to absolute if needed
                       const imgUrl = itm.img.startsWith('/') ? window.location.origin + itm.img : itm.img;
                       const response = await fetch(imgUrl);
                       const blob = await response.blob();
                       const dataUrl = await new Promise(resolve => {
                         const reader = new FileReader();
                         reader.onload = e => resolve(e.target.result);
                         reader.readAsDataURL(blob);
                       });
                       
                       // Detect image format
                       const format = blob.type.includes('png') ? 'PNG' : 'JPEG';
                       
                       imgHeight = 60;
                       cardHeight += imgHeight + 5;
                       doc.addImage(dataUrl, format, 45, y, 120, imgHeight);
                     }catch(e){
                       console.error('Image load error:', e);
                       // Continue without image if loading fails
                     }
                  }
                  doc.roundedRect(15, y-5, 180, cardHeight, 2, 2, 'F');
                  doc.setDrawColor(209, 250, 229);
                  doc.roundedRect(15, y-5, 180, cardHeight, 2, 2, 'S');
                  doc.setTextColor(55,65,81);
                  doc.text(itm.text, 105, y + imgHeight + 5, {align:'center'});
                  y += cardHeight + 10;
                  
                  // Add new page if needed
                  if (y > 260) {
                     doc.addPage();
                     y = 20;
                   }
                 }
 
                 
                doc.save(`${slug}-summary.pdf`);
              };
              if(!window.jspdf && !window.jsPDF){
                const script = document.createElement('script');
                script.src='https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js';
                script.onload = triggerPdf;
                document.body.appendChild(script);
              }else{ triggerPdf(); }
            };
            const cardsHtml = chapter.summary.map(item => {
              const isObj = typeof item === 'object';
              const txt = isObj ? item.text : item;
              const imgBlock = isObj && item.img ? `<img src='${item.img}' class='w-full max-w-2xl rounded-lg mb-3 object-cover mx-auto' alt='summary-img'>` : '';
              return `<div class='flex flex-col items-center bg-emerald-50/60 border border-emerald-100 p-4 rounded-lg'>${imgBlock}<p class='text-gray-800 text-base text-center'>${txt}</p></div>`;
            }).join('');
            viewContainer.innerHTML = `<div class='space-y-4'>${cardsHtml}</div><div class='flex justify-end mt-4'><button onclick='downloadSummary()' class='px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm rounded shadow'>Download PDF</button></div>`;
        }
    }
    
    function renderQuiz(chapter) {
        clearQuizTimer();
        showQuizInstructions(chapter);
    }
    
    function showQuizInstructions(chapter) {
        const instructionsHtml = `
            <div id="quizInstructions" class=" mx-auto">
                <!-- Modal Overlay -->
                <div class="fixed inset-0 bg-black/50 backdrop-blur-md flex items-center justify-center z-50" id="instructionModal">
                    <div class="bg-white rounded-lg shadow-2xl max-w-md w-full mx-4 transform transition-all">
                        <div class="bg-blue-600 text-white p-6 rounded-t-lg">
                            <h2 class="text-2xl font-bold text-center">📝 Quiz Instructions</h2>
                            <p class="text-center text-blue-100 mt-1">${chapter.title}</p>
                        </div>
                        
                        <div class="p-6">
                            <div class="space-y-4 text-gray-700">
                                <div class="flex items-start">
                                    <span class="text-blue-600 font-bold mr-3">⏱️</span>
                                    <div>
                                        <p class="font-semibold">Time Limit</p>
                                        <p class="text-sm">You have <strong>5 minutes</strong> to complete this quiz</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <span class="text-green-600 font-bold mr-3">📋</span>
                                    <div>
                                        <p class="font-semibold">Questions</p>
                                        <p class="text-sm">Answer all <strong>${chapter.quiz.length} questions</strong> by selecting the best option</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <span class="text-orange-600 font-bold mr-3">⚡</span>
                                    <div>
                                        <p class="font-semibold">Auto-Submit</p>
                                        <p class="text-sm">Quiz will automatically submit when time runs out</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <span class="text-purple-600 font-bold mr-3">🎯</span>
                                    <div>
                                        <p class="font-semibold">Scoring System</p>
                                        <p class="text-sm"><strong>+1 mark</strong> for correct answer</p>
                                        <p class="text-sm"><strong>-0.25 marks</strong> for incorrect answer</p>
                                        <p class="text-sm"><strong>0 marks</strong> for blank/unanswered</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mt-6">
                                <div class="flex">
                                    <span class="text-yellow-600 mr-2">⚠️</span>
                                    <p class="text-sm text-yellow-800">
                                        <strong>Important:</strong> Once you start, the timer cannot be paused. Make sure you're ready!
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 px-6 py-4 rounded-b-lg flex justify-between">
                            <button onclick="cancelQuiz()" class="px-4 py-2 text-gray-600 hover:text-gray-800 font-medium transition duration-200">
                                Cancel
                            </button>
                            <button onclick="startQuiz()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200 shadow-lg">
                                🚀 Start Quiz
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Quiz Content (Hidden Initially) -->
                <div id="quizContainer" class="hidden">
                    <div class="bg-emerald-50 p-4 rounded-lg mb-6 flex justify-between items-center border border-emerald-200">
                        <div>
                            <h3 class="text-lg font-semibold text-blue-800">Quiz: ${chapter.title}</h3>
                            <p class="text-sm text-blue-600">Answer all questions and click submit</p>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-extrabold text-emerald-700 font-mono" id="timerDisplay">05:00</div>
                            <div class="text-xs text-emerald-600 uppercase tracking-wide">Time Left</div>
                        </div>
                    </div>
                    
                    <form id="quizForm">
                        ${chapter.quiz.map((q,i)=>`
                            <div class="mb-6 p-5 bg-white rounded-xl border border-emerald-100 shadow-sm hover:shadow-md transition">
                                <p class=\"font-medium mb-3 text-gray-800 text-sm\">${i+1}. ${q.q}</p>
                                ${q.options.map((opt,idx)=>`
                                    <label class="flex items-center mb-2 cursor-pointer hover:bg-emerald-50/60 p-2 rounded">
                                        <input type="radio" name="q${i}" value="${idx}" class="mr-3 text-emerald-600 focus:ring-emerald-500">
                                        <span class=\"text-gray-700 text-sm\">${opt}</span>
                                    </label>
                                `).join('')}
                            </div>
                        `).join('')}
                        
                        <div class="flex justify-center mt-8">
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 text-sm rounded shadow">
                                Submit Quiz
                            </button>
                        </div>
                    </form>
                    
                    <div id="quizResults" class="hidden mt-8"></div>
                </div>
            </div>
        `;
        
        viewContainer.innerHTML = instructionsHtml;
        
        // Store chapter data for later use
        window.currentQuizChapter = chapter;
    }
    
    // Global functions for instruction modal buttons
    window.startQuiz = function() {
        const modal = document.getElementById('instructionModal');
        const quizContainer = document.getElementById('quizContainer');
        
        // Hide the modal
        modal.style.display = 'none';
        
        // Show the quiz
        quizContainer.classList.remove('hidden');
        
        // Start the timer
        startQuizTimer();
        
        // Add form submit handler
        document.getElementById('quizForm').addEventListener('submit', function(e) {
            e.preventDefault();
            submitQuiz(window.currentQuizChapter);
        });
    };
    
    window.cancelQuiz = function() {
        // Switch back to crash course view
        viewSel.value = 'crash';
        render();
    };
    
    function startQuizTimer() {
        quizStartTime = Date.now();
        updateTimerDisplay();
        
        quizTimer = setInterval(() => {
            updateTimerDisplay();
        }, 1000);
    }
    
    function updateTimerDisplay() {
        const elapsed = Math.floor((Date.now() - quizStartTime) / 1000);
        const remaining = Math.max(0, quizTimeLimit - elapsed);
        
        const minutes = Math.floor(remaining / 60);
        const seconds = remaining % 60;
        
        const timerEl = document.getElementById('timerDisplay');
        if (timerEl) {
            timerEl.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            // Change color when time is running low
            if (remaining <= 60) {
                timerEl.className = 'text-2xl font-bold text-red-600';
            } else if (remaining <= 120) {
                timerEl.className = 'text-2xl font-bold text-orange-600';
            }
            
            // Auto-submit when time runs out
            if (remaining === 0) {
                clearQuizTimer();
                const chapter = data[current];
                submitQuiz(chapter, true);
            }
        }
    }
    
    function clearQuizTimer() {
        if (quizTimer) {
            clearInterval(quizTimer);
            quizTimer = null;
        }
    }
    
    function submitQuiz(chapter, timeUp = false) {
        clearQuizTimer();
        
        const form = document.getElementById('quizForm');
        const formData = new FormData(form);
        
        let score = 0;
        let correctAnswers = 0;
        let incorrectAnswers = 0;
        let blankAnswers = 0;
        const results = [];
        
        chapter.quiz.forEach((q, i) => {
            const userAnswerValue = formData.get(`q${i}`);
            const userAnswer = userAnswerValue !== null ? parseInt(userAnswerValue) : null;
            
            let isCorrect = false;
            let isBlank = userAnswer === null;
            let questionScore = 0;
            
            if (isBlank) {
                blankAnswers++;
                questionScore = 0;
            } else if (userAnswer === q.ans) {
                isCorrect = true;
                correctAnswers++;
                questionScore = 1;
            } else {
                incorrectAnswers++;
                questionScore = -0.25;
            }
            
            score += questionScore;
            
            results.push({
                question: q.q,
                userAnswer: isBlank ? 'Not answered' : q.options[userAnswer],
                correctAnswer: q.options[q.ans],
                isCorrect: isCorrect,
                isBlank: isBlank,
                questionScore: questionScore
            });
        });
        
        const maxPossibleScore = chapter.quiz.length;
        const percentage = Math.max(0, Math.round((score / maxPossibleScore) * 100));
        const timeTaken = Math.floor((Date.now() - quizStartTime) / 1000);
        const minutes = Math.floor(timeTaken / 60);
        const seconds = timeTaken % 60;
        
        displayResults(score, chapter.quiz.length, percentage, results, minutes, seconds, timeUp, correctAnswers, incorrectAnswers, blankAnswers);
    }
    
    function displayResults(score, total, percentage, results, minutes, seconds, timeUp, correctAnswers, incorrectAnswers, blankAnswers) {
        const resultsContainer = document.getElementById('quizResults');
        
        let gradeColor = 'text-red-600';
        let grade = 'Needs Improvement';
        
        if (percentage >= 80) {
            gradeColor = 'text-green-600';
            grade = 'Excellent!';
        } else if (percentage >= 60) {
            gradeColor = 'text-blue-600';
            grade = 'Good Job!';
        } else if (percentage >= 40) {
            gradeColor = 'text-yellow-600';
            grade = 'Fair';
        }
        
        const resultsHtml = `
            <div class="bg-white border-2 border-gray-200 rounded-lg p-6 shadow-lg">
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Quiz Results</h3>
                    ${timeUp ? '<p class="text-red-600 font-medium mb-2">⏰ Time\'s up! Quiz auto-submitted.</p>' : ''}
                    <div class="text-4xl font-bold ${gradeColor} mb-2">${percentage}%</div>
                    <div class="text-lg ${gradeColor} font-semibold">${grade}</div>
                    <div class="text-gray-600 mt-2">
                        Total Score: ${score.toFixed(2)}/${total} • Time: ${minutes}:${seconds.toString().padStart(2, '0')}
                    </div>
                    <div class="text-sm text-gray-500 mt-1">
                        Correct: ${correctAnswers} (+${correctAnswers}) • Incorrect: ${incorrectAnswers} (-${(incorrectAnswers * 0.25).toFixed(2)}) • Blank: ${blankAnswers} (0)
                    </div>
                </div>
                
                <div class="space-y-4">
                    <h4 class="text-lg font-semibold text-gray-800 border-b pb-2">Detailed Results:</h4>
                    ${results.map((result, i) => `
                        <div class="p-4 rounded-lg ${result.isCorrect ? 'bg-green-50 border-l-4 border-green-500' : result.isBlank ? 'bg-gray-50 border-l-4 border-gray-400' : 'bg-red-50 border-l-4 border-red-500'}">
                            <p class="font-medium text-gray-800 mb-2">${i+1}. ${result.question}</p>
                            <div class="text-sm">
                                <p class="${result.isCorrect ? 'text-green-700' : result.isBlank ? 'text-gray-600' : 'text-red-700'}">Your answer: ${result.userAnswer}</p>
                                ${!result.isCorrect && !result.isBlank ? `<p class="text-green-700">Correct answer: ${result.correctAnswer}</p>` : ''}
                                <p class="text-xs mt-1 font-medium ${result.isCorrect ? 'text-green-600' : result.isBlank ? 'text-gray-500' : 'text-red-600'}">Score: ${result.questionScore > 0 ? '+' : ''}${result.questionScore}</p>
                            </div>
                        </div>
                    `).join('')}
                </div>
                
                <div class="text-center mt-6">
                    <button onclick="location.reload()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                        Retake Quiz
                    </button>
                </div>
            </div>
        `;
        
        resultsContainer.innerHTML = resultsHtml;
        resultsContainer.classList.remove('hidden');
        
        // Hide the quiz form but keep the container visible
        document.getElementById('quizForm').style.display = 'none';
        
        // Hide the timer header
        const timerHeader = document.querySelector('#quizContainer > div:first-child');
        if (timerHeader) {
            timerHeader.style.display = 'none';
        }
        
        // Scroll to results
        resultsContainer.scrollIntoView({ behavior: 'smooth' });
    }

    // initial render
    render();
  }
  
  // Try to initialize immediately, or retry if COURSE_CONTENT isn't loaded yet
  initializeCourse();
});
</script>
@endsection
