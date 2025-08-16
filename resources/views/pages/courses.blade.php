@extends('layouts.app')

@section('content')
@php
    $levelLabel = match($country){
        'in' => 'Class',
        'uk','au' => 'Year',
        default => 'Grade'
    };
    $maxLevel = in_array($country,['uk','au']) ? 13 : 12;
    // Sample course catalogue (extend as needed)
    $courseCatalogue = [
    // India
    ['country'=>'in','title'=>'Class 8 Maths – ICSE','level'=>8,'subject'=>'Maths','board'=>'ICSE','mode'=>'Offline','description'=>'Maths concepts for Class 8 students.','cta'=>'Enroll Now'],
    ['country'=>'in','title'=>'Class 8 Maths – CBSE','level'=>8,'subject'=>'Maths','board'=>'CBSE','mode'=>'Offline','description'=>'Maths concepts for Class 8 students.','cta'=>'Enroll Now'],
    ['country'=>'in','title'=>'Class 8 Science – CBSE','level'=>8,'subject'=>'Science','board'=>'ICSE','mode'=>'Offline','description'=>'Science concepts for Class 8 students.','cta'=>'View Details'],
    ['country'=>'in','title'=>'Class 8 Science – CBSE','level'=>8,'subject'=>'Science','board'=>'CBSE','mode'=>'Offline','description'=>'Science concepts for Class 8 students.','cta'=>'View Details'],
    ['country'=>'in','title'=>'Class 9 Maths – CBSE','level'=>9,'subject'=>'Maths','board'=>'CBSE','mode'=>'Offline','description'=>'Maths concepts for Class 9 students.','cta'=>'Enroll Now'],
    ['country'=>'in','title'=>'Class 9 Science – ICSE','level'=>9,'subject'=>'Science','board'=>'ICSE','mode'=>'Offline','description'=>'Science concepts for Class 9 students.','cta'=>'View Details'],
    ['country'=>'in','title'=>'Class 10 Maths – CBSE','level'=>10,'subject'=>'Maths','board'=>'CBSE','mode'=>'Offline','description'=>'Maths concepts for Class 10 students.','cta'=>'Enroll Now'],
    ['country'=>'in','title'=>'Class 10 Science – CBSE','level'=>10,'subject'=>'Science','board'=>'CBSE','mode'=>'Offline','description'=>'Science concepts for Class 10 students.','cta'=>'View Details'],
    ['country'=>'in','title'=>'Class 11 Maths – ICSE','level'=>11,'subject'=>'Maths','board'=>'ICSE','mode'=>'Offline','description'=>'Maths concepts for Class 11 students.','cta'=>'View Details'],
    ['country'=>'in','title'=>'Class 11 Physics – CBSE','level'=>11,'subject'=>'Physics','board'=>'CBSE','mode'=>'Offline','description'=>'Physics concepts for Class 11 students.','cta'=>'Enroll Now'],
    ['country'=>'in','title'=>'Class 12 Maths – CBSE','level'=>12,'subject'=>'Maths','board'=>'CBSE','mode'=>'Offline','description'=>'Maths concepts for Class 12 students.','cta'=>'View Details'],
    ['country'=>'in','title'=>'Class 12 Physics – ICSE','level'=>12,'subject'=>'Physics','board'=>'ICSE','mode'=>'Offline','description'=>'Physics concepts for Class 12 students.','cta'=>'Enroll Now'],

    // UK
    ['country'=>'uk','title'=>'Year 8 Maths – AQA','level'=>8,'subject'=>'Maths','board'=>'AQA','mode'=>'Online','description'=>'Maths concepts for Year 8 students.','cta'=>'Enroll Now'],
    ['country'=>'uk','title'=>'Year 8 Science – Edexcel','level'=>8,'subject'=>'Science','board'=>'Edexcel','mode'=>'Online','description'=>'Science concepts for Year 8 students.','cta'=>'View Details'],
    ['country'=>'uk','title'=>'Year 9 Maths – Edexcel','level'=>9,'subject'=>'Maths','board'=>'Edexcel','mode'=>'Online & Offline','description'=>'Maths concepts for Year 9 students.','cta'=>'View Details'],
    ['country'=>'uk','title'=>'Year 9 Science – AQA','level'=>9,'subject'=>'Science','board'=>'AQA','mode'=>'Online & Offline','description'=>'Science concepts for Year 9 students.','cta'=>'Enroll Now'],
    ['country'=>'uk','title'=>'Year 10 Maths – Edexcel','level'=>10,'subject'=>'Maths','board'=>'Edexcel','mode'=>'Online','description'=>'Maths concepts for Year 10 students.','cta'=>'View Details'],
    ['country'=>'uk','title'=>'Year 10 Science – AQA','level'=>10,'subject'=>'Science','board'=>'AQA','mode'=>'Online & Offline','description'=>'Science concepts for Year 10 students.','cta'=>'Enroll Now'],
    ['country'=>'uk','title'=>'Year 11 Maths – AQA','level'=>11,'subject'=>'Maths','board'=>'AQA','mode'=>'Online','description'=>'Maths concepts for Year 11 students.','cta'=>'Enroll Now'],
    ['country'=>'uk','title'=>'Year 11 Physics – Edexcel','level'=>11,'subject'=>'Physics','board'=>'Edexcel','mode'=>'Online & Offline','description'=>'Physics concepts for Year 11 students.','cta'=>'View Details'],
    ['country'=>'uk','title'=>'Year 12 Maths – Edexcel','level'=>12,'subject'=>'Maths','board'=>'Edexcel','mode'=>'Online','description'=>'Maths concepts for Year 12 students.','cta'=>'Enroll Now'],
    ['country'=>'uk','title'=>'Year 12 Physics – AQA','level'=>12,'subject'=>'Physics','board'=>'AQA','mode'=>'Online','description'=>'Physics concepts for Year 12 students.','cta'=>'View Details'],
    ['country'=>'uk','title'=>'Year 13 Maths – AQA','level'=>13,'subject'=>'Maths','board'=>'AQA','mode'=>'Online & Offline','description'=>'Maths concepts for Year 13 students.','cta'=>'Enroll Now'],
    ['country'=>'uk','title'=>'Year 13 Physics – Edexcel','level'=>13,'subject'=>'Physics','board'=>'Edexcel','mode'=>'Online','description'=>'Physics concepts for Year 13 students.','cta'=>'View Details'],

    // USA
    ['country'=>'us','title'=>'Grade 8 Maths – Common Core','level'=>8,'subject'=>'Maths','board'=>'Common Core','mode'=>'Online','description'=>'Aligned with US curriculum.','cta'=>'Enroll Now'],
    ['country'=>'us','title'=>'Grade 8 Science – NGSS','level'=>8,'subject'=>'Science','board'=>'NGSS','mode'=>'Online','description'=>'Explore biology, physics, chemistry basics.','cta'=>'View Details'],
    ['country'=>'us','title'=>'Grade 9 Maths – Common Core','level'=>9,'subject'=>'Maths','board'=>'Common Core','mode'=>'Online & Offline','description'=>'US Grade 9 Algebra & Geometry.','cta'=>'Enroll Now'],
    ['country'=>'us','title'=>'Grade 9 Science – NGSS','level'=>9,'subject'=>'Science','board'=>'NGSS','mode'=>'Online','description'=>'Engaging labs and projects included.','cta'=>'View Details'],
    ['country'=>'us','title'=>'Grade 10 Maths – Common Core','level'=>10,'subject'=>'Maths','board'=>'Common Core','mode'=>'Online','description'=>'Build core math and logic skills.','cta'=>'Enroll Now'],
    ['country'=>'us','title'=>'Grade 10 Science – NGSS','level'=>10,'subject'=>'Science','board'=>'NGSS','mode'=>'Online & Offline','description'=>'Interactive science learning experience.','cta'=>'View Details'],
    ['country'=>'us','title'=>'Grade 11 Maths – Common Core','level'=>11,'subject'=>'Maths','board'=>'Common Core','mode'=>'Online','description'=>'Advanced functions and trigonometry.','cta'=>'View Details'],
    ['country'=>'us','title'=>'Grade 11 Physics – NGSS','level'=>11,'subject'=>'Physics','board'=>'NGSS','mode'=>'Online & Offline','description'=>'Newton’s laws, energy, and motion.','cta'=>'Enroll Now'],
    ['country'=>'us','title'=>'Grade 12 Maths – Common Core','level'=>12,'subject'=>'Maths','board'=>'Common Core','mode'=>'Online','description'=>'Calculus and statistics foundations.','cta'=>'Enroll Now'],
    ['country'=>'us','title'=>'Grade 12 Physics – College Board','level'=>12,'subject'=>'Physics','board'=>'College Board','mode'=>'Online','description'=>'AP Physics preparation content.','cta'=>'View Details'],

    // Canada
    ['country'=>'ca','title'=>'Grade 8 Maths – Ontario','level'=>8,'subject'=>'Maths','board'=>'Ontario','mode'=>'Online','description'=>'Grade 8 Ontario math program.','cta'=>'Enroll Now'],
    ['country'=>'ca','title'=>'Grade 8 Science – BC Curriculum','level'=>8,'subject'=>'Science','board'=>'BC','mode'=>'Online','description'=>'Exploring ecosystems and matter.','cta'=>'View Details'],
    ['country'=>'ca','title'=>'Grade 9 Maths – Ontario','level'=>9,'subject'=>'Maths','board'=>'Ontario','mode'=>'Online & Offline','description'=>'Ontario algebra & expressions.','cta'=>'View Details'],
    ['country'=>'ca','title'=>'Grade 9 Science – BC Curriculum','level'=>9,'subject'=>'Science','board'=>'BC','mode'=>'Online','description'=>'Foundations of physics and biology.','cta'=>'Enroll Now'],
    ['country'=>'ca','title'=>'Grade 10 Maths – Ontario','level'=>10,'subject'=>'Maths','board'=>'Ontario','mode'=>'Online','description'=>'Graphs, equations, polynomials.','cta'=>'View Details'],
    ['country'=>'ca','title'=>'Grade 10 Science – BC Curriculum','level'=>10,'subject'=>'Science','board'=>'BC','mode'=>'Online & Offline','description'=>'Energy, matter, & ecosystems.','cta'=>'Enroll Now'],
    ['country'=>'ca','title'=>'Grade 11 Maths – Ontario','level'=>11,'subject'=>'Maths','board'=>'Ontario','mode'=>'Online','description'=>'Quadratics & exponential functions.','cta'=>'Enroll Now'],
    ['country'=>'ca','title'=>'Grade 11 Physics – BC Curriculum','level'=>11,'subject'=>'Physics','board'=>'BC','mode'=>'Online','description'=>'Mechanics and forces.','cta'=>'View Details'],
    ['country'=>'ca','title'=>'Grade 12 Maths – Ontario','level'=>12,'subject'=>'Maths','board'=>'Ontario','mode'=>'Online','description'=>'Advanced functions and calculus.','cta'=>'Enroll Now'],
    ['country'=>'ca','title'=>'Grade 12 Physics – BC Curriculum','level'=>12,'subject'=>'Physics','board'=>'BC','mode'=>'Online','description'=>'Electricity and magnetism.','cta'=>'View Details'],

    // Australia
    ['country'=>'au','title'=>'Year 8 Maths – NSW','level'=>8,'subject'=>'Maths','board'=>'NSW','mode'=>'Online','description'=>'Australian curriculum-aligned content.','cta'=>'Enroll Now'],
    ['country'=>'au','title'=>'Year 8 Science – VIC','level'=>8,'subject'=>'Science','board'=>'VIC','mode'=>'Online','description'=>'Science projects & activities.','cta'=>'View Details'],
    ['country'=>'au','title'=>'Year 9 Maths – NSW','level'=>9,'subject'=>'Maths','board'=>'NSW','mode'=>'Online & Offline','description'=>'Problem-solving & real-life math.','cta'=>'View Details'],
    ['country'=>'au','title'=>'Year 9 Science – VIC','level'=>9,'subject'=>'Science','board'=>'VIC','mode'=>'Online','description'=>'Chemical reactions & ecology.','cta'=>'Enroll Now'],
    ['country'=>'au','title'=>'Year 10 Maths – NSW','level'=>10,'subject'=>'Maths','board'=>'NSW','mode'=>'Online','description'=>'Functions, geometry, stats.','cta'=>'Enroll Now'],
    ['country'=>'au','title'=>'Year 10 Science – VIC','level'=>10,'subject'=>'Science','board'=>'VIC','mode'=>'Online & Offline','description'=>'Complete Year 10 science course.','cta'=>'View Details'],
    ['country'=>'au','title'=>'Year 11 Maths – NSW','level'=>11,'subject'=>'Maths','board'=>'NSW','mode'=>'Online','description'=>'Advanced mathematics concepts.','cta'=>'View Details'],
    ['country'=>'au','title'=>'Year 11 Physics – VIC','level'=>11,'subject'=>'Physics','board'=>'VIC','mode'=>'Online','description'=>'Physics principles & simulations.','cta'=>'Enroll Now'],
    ['country'=>'au','title'=>'Year 12 Maths – NSW','level'=>12,'subject'=>'Maths','board'=>'NSW','mode'=>'Online','description'=>'Calculus, algebra, probability.','cta'=>'Enroll Now'],
    ['country'=>'au','title'=>'Year 12 Physics – VIC','level'=>12,'subject'=>'Physics','board'=>'VIC','mode'=>'Online','description'=>'Practical physics & theory.','cta'=>'View Details'],
];

    $countryCourses = array_values(array_filter($courseCatalogue, fn($c)=>$c['country']==$country));
@endphp

<div id="coursesApp"
     class="container mx-auto px-4 py-16"
     data-courses='@json($countryCourses)'
     data-level-label="{{ $levelLabel }}"
     data-max-level="{{ $maxLevel }}"
     data-country="{{ $country }}">

    <h1 class="text-3xl font-bold mb-6">Courses Offered – {{ $countryName }}</h1>
    <div class="flex flex-col md:flex-row md:items-end gap-4 mb-8 bg-stone-50/60 p-4 rounded-lg shadow">
        <div>
            <label class="block text-base md:text-lg font-semibold mb-1 text-stone-700" for="levelSelect">Select {{ $levelLabel }}</label>
            <select id="levelSelect" class="w-40 text-sm h-9 border border-amber-400 bg-amber-50/60 rounded-md px-3 focus:outline-none focus:ring-2 focus:ring-amber-600 shadow-inner"></select>
        </div>
        <div>
            <label class="block text-base md:text-lg font-semibold mb-1 text-stone-700" for="boardSelect">Select Board</label>
            <select id="boardSelect" class="w-40 text-sm h-9 border border-blue-400 bg-blue-50/60 rounded-md px-3 focus:outline-none focus:ring-2 focus:ring-blue-600 shadow-inner"></select>
        </div>
        <div id="subjectBlock" class="hidden">
            <label class="block text-base md:text-lg font-semibold mb-1 text-stone-700" for="subjectSelect">Select Subject</label>
            <select id="subjectSelect" class="w-52 text-sm h-9 border border-emerald-400 bg-emerald-50/60 rounded-md px-3 focus:outline-none focus:ring-2 focus:ring-emerald-600 shadow-inner"></select>
        </div>
    </div>

    <div id="coursesGrid" class="grid grid-cols-1 md:grid-cols-3 gap-6" data-aos="fade-up"></div>
</div>

<script defer>
// Basic vanilla JS filtering
(function(){
    const app = document.getElementById('coursesApp');
    if(!app) return;
    const courses = JSON.parse(app.dataset.courses);
    const levelLabel = app.dataset.levelLabel;
    const maxLevel = parseInt(app.dataset.maxLevel);
    const country = app.dataset.country;

    const levelSelect = document.getElementById('levelSelect');
    const boardSelect = document.getElementById('boardSelect');
    const subjectBlock = document.getElementById('subjectBlock');
    const subjectSelect = document.getElementById('subjectSelect');
    const grid = document.getElementById('coursesGrid');
    const colors = ['bg-amber-50','bg-lime-50','bg-emerald-50','bg-orange-50','bg-blue-50','bg-indigo-50','bg-purple-50','bg-pink-50'];

    // Country-specific board options
    const boardOptions = {
        'in': ['CBSE', 'ICSE'],
        'uk': ['AQA', 'Edexcel', 'OCR'],
        'us': ['Common Core', 'NGSS', 'College Board'],
        'ca': ['Ontario', 'BC', 'Alberta'],
        'au': ['NSW', 'VIC', 'QLD']
    };

    // populate level options (8 .. maxLevel)
    const allSorted = [...courses].sort((a,b)=>a.level-b.level);
    renderCourses(allSorted);
    levelSelect.innerHTML = `<option value="">Select ${levelLabel}</option>`;
    for(let l=8; l<=maxLevel; l++){
        levelSelect.innerHTML += `<option value="${l}">${levelLabel} ${l}</option>`;
    }

    // populate board options based on country
    const countryBoards = boardOptions[country] || ['All Boards'];
    boardSelect.innerHTML = '<option value="">Select Board</option>' + 
        countryBoards.map(board => `<option value="${board}">${board}</option>`).join('');

    levelSelect.addEventListener('change', () => {
        const level = parseInt(levelSelect.value);
        if(isNaN(level)){
            subjectBlock.classList.add('hidden');
            subjectSelect.value='';
            renderCourses(allSorted);
            return;
        }
        // determine subjects
        const coreLower = ['Maths','Science'];
        const coreHigher = ['Maths','Physics','Chemistry','Biology','English'];
        const subjects = level <= 10 ? coreLower : coreHigher;
        subjectSelect.innerHTML = '<option value="">Select Subject</option>' + subjects.map(s=>`<option value="${s}">${s}</option>`).join('');
        subjectBlock.classList.remove('hidden');
        subjectSelect.value='';
        filterCourses();
    });

    boardSelect.addEventListener('change', () => {
        filterCourses();
    });

    subjectSelect.addEventListener('change', () => {
        filterCourses();
    });

    function filterCourses(){
        const level = parseInt(levelSelect.value);
        const board = boardSelect.value;
        const subject = subjectSelect.value;
        let filtered = courses;
        if(!isNaN(level)) filtered = filtered.filter(c => c.level === level);
        if(board) filtered = filtered.filter(c => c.board === board);
        if(subject) filtered = filtered.filter(c => c.subject === subject);
        renderCourses(filtered);
    }

    function renderCourses(list){
        if(list.length === 0){
            grid.innerHTML = '<p class="col-span-full text-center text-gray-600">No courses found for the selected filters.</p>';
            return;
        }
        grid.innerHTML = list.map((c,i) => {
            const slug = c.title.toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/^-+|-+$/g,'');
            const linkPrefix = `/${country}/course-detail?slug=${slug}`;
            return `<div class="${colors[i%colors.length]} rounded-lg shadow p-4 text-sm">
                <a href="${linkPrefix}" class="text-2xl font-extrabold block mb-2">📘 ${c.title}</a>
                <p class="text-sm mb-1">${levelLabel} ${c.level} | ${c.board}</p>
                <p class="text-sm mb-1">Mode: ${c.mode}</p>
                <p class="text-sm text-gray-700 mb-4">${c.description}</p>
            </div>`;
        }).join('');
        
    }
})();
</script>
@endsection
