@extends('layouts.app')

@section('content')
@php
    $levelLabel = match($country){
        'in' => 'Class',
        'uk','au' => 'Year',
        default => 'Grade'
    };
    $maxLevel = in_array($country,['uk','au']) ? 13 : 12;
    
    // Co-curricular activities catalogue
    $cocurricularCatalogue = [
        // India
        ['country'=>'in','title'=>'Drawing Fundamentals','level'=>8,'subject'=>'Art','category'=>'Visual Arts','mode'=>'Online','description'=>'Learn line, shape and shade basics with structured lessons.','cta'=>'Enroll Now','icon'=>'🖍️'],
        ['country'=>'in','title'=>'Sketching & Illustration','level'=>9,'subject'=>'Art','category'=>'Visual Arts','mode'=>'Online','description'=>'Develop sketching techniques and perspective drawing.','cta'=>'View Details','icon'=>'✏️'],
        ['country'=>'in','title'=>'Watercolour Painting','level'=>10,'subject'=>'Art','category'=>'Visual Arts','mode'=>'Online','description'=>'Explore washes, blending and colour theory fundamentals.','cta'=>'Enroll Now','icon'=>'🎨'],
        ['country'=>'in','title'=>'Modern Calligraphy','level'=>8,'subject'=>'Art','category'=>'Visual Arts','mode'=>'Online','description'=>'Master brush lettering and various calligraphy styles.','cta'=>'View Details','icon'=>'✒️'],
        ['country'=>'in','title'=>'Digital Art Basics','level'=>11,'subject'=>'Art','category'=>'Digital Arts','mode'=>'Online','description'=>'Introduction to digital illustration and design tools.','cta'=>'Enroll Now','icon'=>'💻'],
        ['country'=>'in','title'=>'Photography Essentials','level'=>12,'subject'=>'Photography','category'=>'Visual Arts','mode'=>'Online','description'=>'Learn composition, lighting and basic photo editing.','cta'=>'View Details','icon'=>'📸'],
        ['country'=>'in','title'=>'Creative Writing','level'=>9,'subject'=>'Writing','category'=>'Literature','mode'=>'Online','description'=>'Develop storytelling skills and creative expression.','cta'=>'Enroll Now','icon'=>'✍️'],
        ['country'=>'in','title'=>'Public Speaking','level'=>10,'subject'=>'Communication','category'=>'Life Skills','mode'=>'Online','description'=>'Build confidence in presentations and communication.','cta'=>'View Details','icon'=>'🎤'],

        // UK
        ['country'=>'uk','title'=>'Art & Design Foundation','level'=>8,'subject'=>'Art','category'=>'Visual Arts','mode'=>'Online','description'=>'Explore various art mediums and techniques.','cta'=>'Enroll Now','icon'=>'🎨'],
        ['country'=>'uk','title'=>'Drama & Theatre','level'=>9,'subject'=>'Drama','category'=>'Performing Arts','mode'=>'Online','description'=>'Acting techniques and script interpretation.','cta'=>'View Details','icon'=>'🎭'],
        ['country'=>'uk','title'=>'Music Theory & Practice','level'=>10,'subject'=>'Music','category'=>'Performing Arts','mode'=>'Online','description'=>'Learn music fundamentals and instrument basics.','cta'=>'Enroll Now','icon'=>'🎵'],
        ['country'=>'uk','title'=>'Creative Photography','level'=>11,'subject'=>'Photography','category'=>'Visual Arts','mode'=>'Online','description'=>'Advanced photography techniques and portfolio building.','cta'=>'View Details','icon'=>'📷'],
        ['country'=>'uk','title'=>'Digital Media Design','level'=>12,'subject'=>'Design','category'=>'Digital Arts','mode'=>'Online','description'=>'Graphic design and multimedia creation skills.','cta'=>'Enroll Now','icon'=>'🖥️'],
        ['country'=>'uk','title'=>'Debate & Discussion','level'=>10,'subject'=>'Communication','category'=>'Life Skills','mode'=>'Online','description'=>'Develop argumentation and critical thinking skills.','cta'=>'View Details','icon'=>'💬'],

        // USA
        ['country'=>'us','title'=>'Visual Arts Studio','level'=>8,'subject'=>'Art','category'=>'Visual Arts','mode'=>'Online','description'=>'Comprehensive art program covering multiple mediums.','cta'=>'Enroll Now','icon'=>'🎨'],
        ['country'=>'us','title'=>'Creative Writing Workshop','level'=>9,'subject'=>'Writing','category'=>'Literature','mode'=>'Online','description'=>'Poetry, short stories, and creative expression.','cta'=>'View Details','icon'=>'📝'],
        ['country'=>'us','title'=>'Theater Arts','level'=>10,'subject'=>'Drama','category'=>'Performing Arts','mode'=>'Online','description'=>'Acting, directing, and stage production basics.','cta'=>'Enroll Now','icon'=>'🎬'],
        ['country'=>'us','title'=>'Digital Photography','level'=>11,'subject'=>'Photography','category'=>'Visual Arts','mode'=>'Online','description'=>'Modern photography with digital editing techniques.','cta'=>'View Details','icon'=>'📸'],
        ['country'=>'us','title'=>'Music Production','level'=>12,'subject'=>'Music','category'=>'Performing Arts','mode'=>'Online','description'=>'Learn music creation using digital audio workstations.','cta'=>'Enroll Now','icon'=>'🎧'],
        ['country'=>'us','title'=>'Leadership Skills','level'=>11,'subject'=>'Leadership','category'=>'Life Skills','mode'=>'Online','description'=>'Develop leadership qualities and team management.','cta'=>'View Details','icon'=>'👥'],

        // Canada
        ['country'=>'ca','title'=>'Indigenous Arts & Culture','level'=>8,'subject'=>'Art','category'=>'Cultural Arts','mode'=>'Online','description'=>'Explore traditional and contemporary Indigenous art forms.','cta'=>'Enroll Now','icon'=>'🪶'],
        ['country'=>'ca','title'=>'Environmental Photography','level'=>9,'subject'=>'Photography','category'=>'Visual Arts','mode'=>'Online','description'=>'Nature photography and environmental storytelling.','cta'=>'View Details','icon'=>'🌲'],
        ['country'=>'ca','title'=>'French Creative Writing','level'=>10,'subject'=>'Writing','category'=>'Literature','mode'=>'Online','description'=>'Creative expression in French language and culture.','cta'=>'Enroll Now','icon'=>'🇫🇷'],
        ['country'=>'ca','title'=>'Community Service Projects','level'=>11,'subject'=>'Service','category'=>'Life Skills','mode'=>'Online','description'=>'Plan and execute meaningful community initiatives.','cta'=>'View Details','icon'=>'🤝'],
        ['country'=>'ca','title'=>'Multimedia Storytelling','level'=>12,'subject'=>'Media','category'=>'Digital Arts','mode'=>'Online','description'=>'Combine video, audio, and text for compelling narratives.','cta'=>'Enroll Now','icon'=>'📹'],

        // Australia
        ['country'=>'au','title'=>'Aboriginal Art Appreciation','level'=>8,'subject'=>'Art','category'=>'Cultural Arts','mode'=>'Online','description'=>'Learn about traditional and contemporary Aboriginal art.','cta'=>'Enroll Now','icon'=>'🎨'],
        ['country'=>'au','title'=>'Surf Photography','level'=>9,'subject'=>'Photography','category'=>'Visual Arts','mode'=>'Online','description'=>'Capture the beauty of Australian coastal life.','cta'=>'View Details','icon'=>'🏄'],
        ['country'=>'au','title'=>'Bush Poetry & Writing','level'=>10,'subject'=>'Writing','category'=>'Literature','mode'=>'Online','description'=>'Explore Australian literary traditions and bush poetry.','cta'=>'Enroll Now','icon'=>'📖'],
        ['country'=>'au','title'=>'Wildlife Documentary','level'=>11,'subject'=>'Media','category'=>'Digital Arts','mode'=>'Online','description'=>'Create documentaries about Australian wildlife.','cta'=>'View Details','icon'=>'🦘'],
        ['country'=>'au','title'=>'Environmental Activism','level'=>12,'subject'=>'Activism','category'=>'Life Skills','mode'=>'Online','description'=>'Learn to advocate for environmental causes effectively.','cta'=>'Enroll Now','icon'=>'🌍'],
    ];

    $countryCocurricular = array_values(array_filter($cocurricularCatalogue, fn($c)=>$c['country']==$country));
@endphp

<div id="cocurricularApp"
     class="container mx-auto px-4 py-16"
     data-activities='@json($countryCocurricular)'
     data-level-label="{{ $levelLabel }}"
     data-max-level="{{ $maxLevel }}"
     data-country="{{ $country }}">

    <h1 class="text-3xl font-bold mb-6">🎨 Co-Curricular Activities – {{ $countryName }}</h1>
    <p class="text-lg text-gray-600 mb-8">Explore creative and enriching activities that complement your academic journey and develop well-rounded skills.</p>
    
    <div class="flex flex-col md:flex-row md:items-end gap-4 mb-8 bg-stone-50/60 p-4 rounded-lg shadow">
        <div>
            <label class="block text-base md:text-lg font-semibold mb-1 text-stone-700" for="levelSelect">Select {{ $levelLabel }}</label>
            <select id="levelSelect" class="w-40 text-sm h-9 border border-amber-400 bg-amber-50/60 rounded-md px-3 focus:outline-none focus:ring-2 focus:ring-amber-600 shadow-inner"></select>
        </div>
        <div>
            <label class="block text-base md:text-lg font-semibold mb-1 text-stone-700" for="categorySelect">Select Category</label>
            <select id="categorySelect" class="w-52 text-sm h-9 border border-blue-400 bg-blue-50/60 rounded-md px-3 focus:outline-none focus:ring-2 focus:ring-blue-600 shadow-inner"></select>
        </div>
        <div id="subjectBlock" class="hidden">
            <label class="block text-base md:text-lg font-semibold mb-1 text-stone-700" for="subjectSelect">Select Subject</label>
            <select id="subjectSelect" class="w-52 text-sm h-9 border border-emerald-400 bg-emerald-50/60 rounded-md px-3 focus:outline-none focus:ring-2 focus:ring-emerald-600 shadow-inner"></select>
        </div>
    </div>

    <div id="activitiesGrid" class="grid grid-cols-1 md:grid-cols-3 gap-6" data-aos="fade-up"></div>
</div>

<script defer>
// Cocurricular activities filtering
(function(){
    const app = document.getElementById('cocurricularApp');
    if(!app) return;
    const activities = JSON.parse(app.dataset.activities);
    const levelLabel = app.dataset.levelLabel;
    const maxLevel = parseInt(app.dataset.maxLevel);
    const country = app.dataset.country;

    const levelSelect = document.getElementById('levelSelect');
    const categorySelect = document.getElementById('categorySelect');
    const subjectBlock = document.getElementById('subjectBlock');
    const subjectSelect = document.getElementById('subjectSelect');
    const grid = document.getElementById('activitiesGrid');
    const colors = ['bg-amber-50','bg-lime-50','bg-emerald-50','bg-orange-50','bg-blue-50','bg-indigo-50','bg-purple-50','bg-pink-50'];

    // Get unique categories
    const categories = [...new Set(activities.map(a => a.category))].sort();

    // populate level options (8 .. maxLevel)
    const allSorted = [...activities].sort((a,b)=>a.level-b.level);
    renderActivities(allSorted);
    levelSelect.innerHTML = `<option value="">All ${levelLabel}s</option>`;
    for(let l=8; l<=maxLevel; l++){
        levelSelect.innerHTML += `<option value="${l}">${levelLabel} ${l}</option>`;
    }

    // populate category options
    categorySelect.innerHTML = '<option value="">All Categories</option>' + 
        categories.map(cat => `<option value="${cat}">${cat}</option>`).join('');

    levelSelect.addEventListener('change', () => {
        const level = parseInt(levelSelect.value);
        if(isNaN(level)){
            subjectBlock.classList.add('hidden');
            subjectSelect.value='';
            renderActivities(allSorted);
        } else {
            const filtered = activities.filter(a => a.level === level);
            renderActivities(filtered);
            populateSubjects(filtered);
        }
    });

    categorySelect.addEventListener('change', () => {
        const category = categorySelect.value;
        const level = parseInt(levelSelect.value);
        
        let filtered = activities;
        if(category) filtered = filtered.filter(a => a.category === category);
        if(!isNaN(level)) filtered = filtered.filter(a => a.level === level);
        
        renderActivities(filtered);
        if(!isNaN(level)) populateSubjects(filtered);
    });

    subjectSelect.addEventListener('change', () => {
        const subject = subjectSelect.value;
        const category = categorySelect.value;
        const level = parseInt(levelSelect.value);
        
        let filtered = activities;
        if(subject) filtered = filtered.filter(a => a.subject === subject);
        if(category) filtered = filtered.filter(a => a.category === category);
        if(!isNaN(level)) filtered = filtered.filter(a => a.level === level);
        
        renderActivities(filtered);
    });

    function populateSubjects(filtered) {
        const subjects = [...new Set(filtered.map(a => a.subject))].sort();
        if(subjects.length > 1) {
            subjectBlock.classList.remove('hidden');
            subjectSelect.innerHTML = '<option value="">All Subjects</option>' + 
                subjects.map(subj => `<option value="${subj}">${subj}</option>`).join('');
        } else {
            subjectBlock.classList.add('hidden');
            subjectSelect.value = '';
        }
    }

    function renderActivities(list) {
        if(list.length === 0) {
            grid.innerHTML = '<div class="col-span-full text-center py-8 text-gray-500">No activities found for the selected criteria.</div>';
            return;
        }
        
        grid.innerHTML = list.map((activity, i) => `
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-${getBorderColor(activity.category)} hover:shadow-lg transition-shadow">
                <div class="flex items-start justify-between mb-3">
                    <div class="text-3xl">${activity.icon}</div>
                    <span class="text-xs px-2 py-1 bg-gray-100 rounded-full text-gray-600">${activity.category}</span>
                </div>
                <h3 class="text-lg font-semibold mb-2">${activity.title}</h3>
                <div class="text-sm text-gray-600 space-y-1 mb-3">
                    <div>🎯 ${levelLabel} ${activity.level}</div>
                    <div>📚 ${activity.subject}</div>
                    <div>🧑‍🏫 ${activity.mode}</div>
                </div>
                <p class="text-sm text-gray-700 mb-4">${activity.description}</p>
                <a href="/${country}/course-detail?type=cocurricular&activity=${encodeURIComponent(activity.title)}" 
                   class="inline-block px-4 py-2 text-sm font-medium rounded-md transition-colors ${activity.cta === 'Enroll Now' ? 'bg-blue-600 text-white hover:bg-blue-700' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'}">
                    ${activity.cta}
                </a>
            </div>
        `).join('');
    }

    function getBorderColor(category) {
        const colorMap = {
            'Visual Arts': 'purple-500',
            'Performing Arts': 'pink-500',
            'Digital Arts': 'blue-500',
            'Literature': 'green-500',
            'Life Skills': 'orange-500',
            'Cultural Arts': 'indigo-500'
        };
        return colorMap[category] || 'gray-500';
    }
})();
</script>
@endsection
