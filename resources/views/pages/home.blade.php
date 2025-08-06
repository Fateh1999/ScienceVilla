@extends('layouts.app')

@push('styles')
<style>
.course-card { transition: transform 0.2s ease; }
</style>
@endpush

@section('content')
{{-- Hero Banner --}}
<section class="relative isolate h-[50vh] md:h-[70vh] bg-cover bg-center" style="background-image:url('/images/hero.jpg')">
    <!-- Gradient overlay -->
    <div class="absolute inset-0 bg-gradient-to-b from-sky-900/90 via-indigo-900/80 to-sky-900/90"></div>

    <!-- Decorative blurred circles -->
    <span class="absolute -top-10 -left-10 w-60 h-60 bg-sky-400/40 rounded-full blur-3xl"></span>
    <span class="absolute top-20 right-0 w-96 h-96 bg-indigo-400/30 rounded-full blur-3xl"></span>

    <!-- Content -->
    <div class="relative z-10 h-full flex items-center px-6 lg:px-16" data-aos="fade-right">
        <div class="max-w-3xl text-white space-y-6">
            <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold leading-tight bg-gradient-to-r from-yellow-400 via-pink-500 to-purple-600 text-transparent bg-clip-text drop-shadow-lg">
                Empowering Future Scholars Worldwide
            </h1>
            <!-- Accent divider -->
            <div class="h-1 w-24 bg-gradient-to-r from-yellow-400 via-pink-500 to-purple-600 rounded-full"></div>
            <p class="text-lg sm:text-2xl lg:text-3xl font-semibold tracking-wide drop-shadow text-white/95">Personalized Coaching for {{ $countryName }} Curriculum</p>
            <div class="flex flex-wrap items-center gap-4 text-white/85 text-sm sm:text-base lg:text-lg">
                    <div class="flex items-center gap-1"><i class="bi bi-mortarboard-fill text-yellow-400"></i><span> &nbsp; Expert Tutors</span></div>
                    <span class="hidden sm:block">|</span>
                    <div class="flex items-center gap-1"><i class="bi bi-lightbulb-fill text-pink-500"></i><span> &nbsp; Weekly Tests</span></div>
                    <span class="hidden sm:block">|</span>
                    <div class="flex items-center gap-1"><i class="bi bi-question-circle-fill text-purple-400"></i><span> &nbsp; 24×7 Doubt Support</span></div>
                </div>
            <div class="space-x-4 pt-2" data-aos="zoom-in" data-aos-delay="300">
                <a href="/{{ $country }}/courses" class="relative inline-flex items-center gap-2 px-1 py-1 rounded-full bg-gradient-to-r from-pink-500 to-yellow-500 hover:from-yellow-500 hover:to-pink-500 focus:outline-none focus:ring-2 focus:ring-pink-400/50 transition duration-500 ease-in-out">  
                        <span class="relative flex items-center gap-2 px-6 py-3 text-base font-semibold text-white bg-sky-900/80 rounded-full backdrop-blur-md">
                            <i class="bi bi-journal-bookmark-fill"></i><span>View Courses</span>
                        </span>
                    </a>
                <a href="/{{ $country }}/contact" class="relative inline-flex items-center gap-2 px-6 py-3 text-base font-semibold text-sky-900 rounded-full bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white/70 transition">  
                        <i class="bi bi-telephone-fill text-pink-600"></i><span>Free Demo</span>
                    </a>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 text-white opacity-70 animate-bounce" data-aos="fade-up" data-aos-delay="600">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>
</section>

{{-- Stats Row --}}
<section class="bg-white shadow py-[3vh]" data-aos="fade-up" data-aos-delay="500">
    <div class="container mx-auto px-4 grid grid-cols-1 sm:grid-cols-3 gap-6 text-center">
        <div>
            <p class="text-3xl font-extrabold text-blue-600 counter" data-count="6">0+</p>
            <p class="mt-1 uppercase text-sm text-gray-600">Years Experience</p>
        </div>
        <div>
            <p class="text-3xl font-extrabold text-blue-600 counter" data-count="1200">0+</p>
            <p class="mt-1 uppercase text-sm text-gray-600">Students Taught</p>
        </div>
        <div>
            <p class="text-3xl font-extrabold text-blue-600 counter" data-count="92" data-percent="1">0%</p>
            <p class="mt-1 uppercase text-sm text-gray-600">Success Rate</p>
        </div>
    </div>
</section>

{{-- Why Choose Us --}}
<section class="container mx-auto px-4 py-16 bg-gray-50 border-t border-gray-200" data-aos="fade-up" data-aos-delay="600">
    <h1 class="text-4xl font-bold text-center mb-10">Why Choose Science Villa?</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 text-center" data-aos="fade-up" data-aos-delay="100">
@php
        $why = [
            ['icon'=>'🧑‍🏫','text'=>'Experienced Tutors','grad'=>'from-purple-500 to-indigo-500'],
            ['icon'=>'🤝','text'=>'One-on-One Doubt Sessions','grad'=>'from-pink-500 to-rose-500'],
            ['icon'=>'📝','text'=>'Weekly Mock Tests','grad'=>'from-orange-400 to-amber-500'],
            ['icon'=>'📈','text'=>'Personalized Feedback','grad'=>'from-teal-500 to-emerald-500'],
            ['icon'=>'🌐','text'=>'Online & Offline Modes','grad'=>'from-sky-500 to-blue-500'],
            ['icon'=>'👨‍👩‍👧‍👦','text'=>'Trusted by Parents Globally','grad'=>'from-lime-500 to-green-500'],
        ];
        @endphp
        @php
    $altGrad = [
        'from-indigo-800 to-purple-800',   // darker variant for Experienced Tutors card
        'from-rose-800 to-pink-800',      // darker variant for Doubt Sessions card
        'from-orange-700 to-amber-700',   // darker variant for Mock Tests card
        'from-emerald-800 to-teal-800',   // darker variant for Feedback card
        'from-blue-800 to-sky-800',       // darker variant for Modes card
        'from-green-800 to-lime-800',     // darker variant for Trust card
    ];
@endphp
@foreach($why as $w)
        <div class="relative group" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
            <!-- Rotated gradient background */-->
            <div class="absolute inset-0 bg-gradient-to-br {{ $altGrad[$loop->index % count($altGrad)] }} rounded-2xl transform rotate-1 group-hover:rotate-2 transition-transform duration-300"></div>
            <!-- Foreground card -->
            <div class="relative bg-gradient-to-br {{ $w['grad'] }} p-8 rounded-2xl shadow-lg flex flex-col items-center text-white">
                <div class="text-4xl mb-4">{{ $w['icon'] }}</div>
                <p class="font-semibold leading-snug text-base text-white">{{ $w['text'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- Featured Courses --}}
<section class="relative py-16 border-t border-gray-200 bg-cover bg-center" style="background-image:url('/images/featured-bg.jpg')">
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="relative container mx-auto px-4">
        <h1 class="text-4xl font-bold mb-8 text-center text-white">📘 Featured Courses – {{ $countryName }}</h1>
            @php
                $coursesMap = [
                    'in' => [
                        [
                            'title' => 'CBSE Class 10 Science',
                            'grade' => 'Class 10',
                            'board' => 'CBSE',
                            'duration' => '1 Year',
                            'mode' => 'Online & Offline',
                            'description' => 'Comprehensive Physics, Chemistry & Biology with weekly tests.',
                            'cta' => 'View Details',
                        ],
                        [
                            'title' => 'NEET 2026 Crash Course',
                            'grade' => '12th Appearing',
                            'board' => 'CBSE/State',
                            'duration' => '4 Months',
                            'mode' => 'Online',
                            'description' => 'Fast-track course covering full syllabus with daily practice papers.',
                            'cta' => 'Enroll Now',
                        ],
                        [
                            'title' => 'JEE Foundation – Class 9',
                            'grade' => 'Class 9',
                            'board' => 'CBSE/ICSE',
                            'duration' => '1 Year',
                            'mode' => 'Offline',
                            'description' => 'Early exposure to problem-solving, Physics & Maths for IIT prep.',
                            'cta' => 'View Details',
                        ],
                    ],
                    'uk' => [
                        [
                            'title' => 'GCSE Physics – AQA',
                            'grade' => 'Year 10–11',
                            'board' => 'AQA',
                            'duration' => '9 Months',
                            'mode' => 'Online',
                            'description' => 'Master concepts with past paper practice & exam-style questions.',
                            'cta' => 'View Details',
                        ],
                        [
                            'title' => 'A-Level Maths – Edexcel',
                            'grade' => 'Year 12–13',
                            'board' => 'Edexcel',
                            'duration' => '1 Year',
                            'mode' => 'Online',
                            'description' => 'Pure, Stats & Mechanics with live sessions & support.',
                            'cta' => 'Enroll Now',
                        ],
                        [
                            'title' => 'KS3 Science Booster',
                            'grade' => 'Year 7–9',
                            'board' => 'UK National Curriculum',
                            'duration' => '6 Months',
                            'mode' => 'Online',
                            'description' => 'Bridge the gap to GCSE with engaging weekly science sessions.',
                            'cta' => 'View Details',
                        ],
                    ],
                    'us' => [
                        [
                            'title' => 'AP Physics 1 – Full Prep',
                            'grade' => 'Grade 11–12',
                            'board' => 'College Board',
                            'duration' => '1 Academic Year',
                            'mode' => 'Online',
                            'description' => 'Complete AP-aligned course with concept videos and mock tests.',
                            'cta' => 'View Details',
                        ],
                        [
                            'title' => 'SAT Math Intensive',
                            'grade' => 'Grade 10–12',
                            'board' => 'SAT',
                            'duration' => '3 Months',
                            'mode' => 'Online',
                            'description' => 'Master algebra, geometry & problem-solving with strategy sessions.',
                            'cta' => 'Enroll Now',
                        ],
                        [
                            'title' => 'Middle School Math – Common Core',
                            'grade' => 'Grade 6–8',
                            'board' => 'Common Core',
                            'duration' => '6 Months',
                            'mode' => 'Online',
                            'description' => 'Skill-building with interactive exercises & regular assessments.',
                            'cta' => 'View Details',
                        ],
                    ],
                    'ca' => [
                        [
                            'title' => 'Grade 10 Science – Ontario Curriculum',
                            'grade' => 'Grade 10',
                            'board' => 'Ontario',
                            'duration' => '1 Year',
                            'mode' => 'Online',
                            'description' => 'Detailed lessons in Biology, Chemistry, Physics with labs & tasks.',
                            'cta' => 'View Details',
                        ],
                        [
                            'title' => 'Canadian University Prep – Maths',
                            'grade' => 'Grade 11–12',
                            'board' => 'Canada (All Provinces)',
                            'duration' => '9 Months',
                            'mode' => 'Online',
                            'description' => 'Designed to meet prerequisites for top universities in Canada.',
                            'cta' => 'Enroll Now',
                        ],
                        [
                            'title' => 'BC Grade 9 English Skills',
                            'grade' => 'Grade 9',
                            'board' => 'British Columbia',
                            'duration' => '6 Months',
                            'mode' => 'Online',
                            'description' => 'Boost reading & writing with creative tasks and grammar drills.',
                            'cta' => 'View Details',
                        ],
                    ],
                    'au' => [
                        [
                            'title' => 'NAPLAN Year 7 Prep – English & Maths',
                            'grade' => 'Year 7',
                            'board' => 'NAPLAN',
                            'duration' => '3 Months',
                            'mode' => 'Online',
                            'description' => 'Ace national assessments with test-oriented practice sessions.',
                            'cta' => 'View Details',
                        ],
                        [
                            'title' => 'VCE Chemistry – Full Course',
                            'grade' => 'Year 11–12',
                            'board' => 'VCE',
                            'duration' => '1 Academic Year',
                            'mode' => 'Online',
                            'description' => 'Concept-based lessons with exam prep and lab tasks.',
                            'cta' => 'Enroll Now',
                        ],
                        [
                            'title' => 'HSC Advanced Maths – NSW',
                            'grade' => 'Year 12',
                            'board' => 'HSC',
                            'duration' => '9 Months',
                            'mode' => 'Online',
                            'description' => 'In-depth preparation with worked solutions and feedback sessions.',
                            'cta' => 'View Details',
                        ],
                    ],
                ];
                $featuredCourses = $coursesMap[$country] ?? $coursesMap['in'];
            @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
            @foreach($featuredCourses as $c)
            <div class="bg-white rounded-xl shadow-lg p-8 flex flex-col h-full">
                <h3 class="text-xl font-semibold mb-2">📘 {{ $c['title'] }}</h3>
                <p class="text-base mb-1">🎯 {{ $c['grade'] }}</p>
                <p class="text-base mb-1">🧠 {{ $c['board'] }}</p>
                <p class="text-base mb-1">⏱ {{ $c['duration'] }}</p>
                <p class="text-base mb-1">🧑‍🏫 {{ $c['mode'] }}</p>
                <p class="text-sm text-gray-700 mb-4">{{ $c['description'] }}</p>
                <a href="/{{ $country }}/courses" class="mt-auto btn {{ $c['cta'] == 'Enroll Now' ? 'btn-primary' : 'btn-outline' }} btn-sm">{{ $c['cta'] }}</a>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-8">
            <a href="/{{ $country }}/courses" class="btn btn-outline btn-sm">🔍 Browse All Courses</a>
        </div>
    </div>
</section>

{{-- Co-Curricular Courses --}}
<section class="relative py-16 border-gray-200 bg-cover bg-center" style="background-image:url('/images/cocurricular-bg.jpg')">
    <div class="absolute inset-0 bg-white/20"></div>
    <div class="relative container mx-auto px-4">
        <h1 class="text-4xl font-bold mb-8 text-center text-gray-900">🎨 Co-Curricular Courses</h1>
        @php
            $coCourses = [
                ['title' => 'Drawing Fundamentals', 'icon' => '🖍️', 'duration' => '6 Weeks', 'mode' => 'Online', 'description' => 'Learn line, shape and shade basics.', 'cta' => 'Enroll Now', 'img' => '/images/drawing.jpeg'],
                ['title' => 'Sketching & Illustration', 'icon' => '✏️', 'duration' => '8 Weeks', 'mode' => 'Online', 'description' => 'Develop sketching techniques and perspective.', 'cta' => 'View Details', 'img' => '/images/sketching.jpeg'],
                ['title' => 'Watercolour Painting', 'icon' => '🎨', 'duration' => '10 Weeks', 'mode' => 'Online', 'description' => 'Explore washes, blending and colour theory.', 'cta' => 'Enroll Now', 'img' => '/images/painting.jpeg'],
                ['title' => 'Modern Calligraphy', 'icon' => '✒️', 'duration' => '4 Weeks', 'mode' => 'Online', 'description' => 'Master brush lettering and styles.', 'cta' => 'View Details', 'img' => '/images/calligraphy.jpeg'],
            ];
        @endphp
        <div class="card-container grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 items-stretch" style="grid-auto-rows:1fr">
            @foreach($coCourses as $c)
            <div class="bg-gray-900 bg-cover bg-center text-white rounded-xl shadow-lg p-8 flex flex-col h-full course-card" style="background-image:linear-gradient(rgba(0,0,0,0.6),rgba(0,0,0,0.6)), url('{{ $c['img'] }}')">
                <h3 class="text-xl font-semibold mb-2">{{ $c['icon'] }} {{ $c['title'] }}</h3>
                <p class="text-base mb-1">⏱ {{ $c['duration'] }}</p>
                <p class="text-base mb-1">🧑‍🏫 {{ $c['mode'] }}</p>
                <p class="text-sm text-gray-200 mb-4">{{ $c['description'] }}</p>
                <a href="/{{ $country }}/courses" class="mt-auto btn {{ $c['cta'] == 'Enroll Now' ? 'btn-primary' : 'btn-outline' }} btn-sm">{{ $c['cta'] }}</a>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="/{{ $country }}/courses" class="btn btn-outline btn-sm">✨ Explore All Co-Curricular</a>
        </div>
    </div>
</section>

{{-- Toppers Carousel (continuous auto-scrolling marquee) --}}
<section class="bg-white border-t border-gray-200 py-16">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-center mb-8">🎉 Meet Our Toppers</h1>
        
        <!-- Marquee - full width -->
        <div class="relative overflow-hidden w-screen left-1/2 -translate-x-1/2 transform" data-aos="fade-up" data-aos-delay="300">
            <div class="marquee-container py-8">
                <div class="marquee-content">
                    @foreach([
                        ['name'=>'Aarav Sharma','detail'=>'98% CBSE Class 10','img'=>'/images/topper1.jpg'],
                        ['name'=>'Sarah Kumar','detail'=>'Grade 9 – AQA GCSE','img'=>'/images/topper2.jpg'],
                        ['name'=>'Rajat Bains','detail'=>'710/720 NEET 2024','img'=>'/images/topper3.jpg'],
                        ['name'=>'Emma Lee','detail'=>'SAT 1540/1600','img'=>'/images/topper4.jpg'],
                        ['name'=>'Priya Patel','detail'=>'95% CBSE Class 12','img'=>'/images/topper1.jpg'],
                        ['name'=>'Michael Chen','detail'=>'A* A-Level Physics','img'=>'/images/topper2.jpg'],
                        ['name'=>'Ananya Singh','detail'=>'JEE Main 99.8%','img'=>'/images/topper3.jpg'],
                        ['name'=>'David Wilson','detail'=>'AP Calculus 5/5','img'=>'/images/topper4.jpg'],
                    ] as $t)
                        <div class="topper-card">
                            <img src="{{ $t['img'] }}" alt="{{ $t['name'] }}" class="w-32 h-32 object-cover rounded-full mx-auto mb-4">
                            <p class="font-semibold">{{ $t['name'] }}</p>
                            <p class="text-sm text-gray-600">{{ $t['detail'] }}</p>
                        </div>
                    @endforeach
                </div>
                <!-- Duplicate content for seamless loop -->
                <div class="marquee-content" aria-hidden="true">
                    @foreach([
                        ['name'=>'Aarav Sharma','detail'=>'98% CBSE Class 10','img'=>'/images/topper1.jpg'],
                        ['name'=>'Sarah Kumar','detail'=>'Grade 9 – AQA GCSE','img'=>'/images/topper2.jpg'],
                        ['name'=>'Rajat Bains','detail'=>'710/720 NEET 2024','img'=>'/images/topper3.jpg'],
                        ['name'=>'Emma Lee','detail'=>'SAT 1540/1600','img'=>'/images/topper4.jpg'],
                        ['name'=>'Priya Patel','detail'=>'95% CBSE Class 12','img'=>'/images/topper1.jpg'],
                        ['name'=>'Michael Chen','detail'=>'A* A-Level Physics','img'=>'/images/topper2.jpg'],
                        ['name'=>'Ananya Singh','detail'=>'JEE Main 99.8%','img'=>'/images/topper3.jpg'],
                        ['name'=>'David Wilson','detail'=>'AP Calculus 5/5','img'=>'/images/topper4.jpg'],
                    ] as $t)
                        <div class="topper-card">
                            <img src="{{ $t['img'] }}" alt="{{ $t['name'] }}" class="w-32 h-32 object-cover rounded-full mx-auto mb-4">
                            <p class="font-semibold">{{ $t['name'] }}</p>
                            <p class="text-sm text-gray-600">{{ $t['detail'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="text-center mt-6">
            <a href="/{{ $country }}/results" class="btn btn-outline btn-sm">📜 See Full Result List</a>
        </div>
</section>

{{-- Testimonials --}}
<section class="bg-gray-50 py-16 border-t border-gray-200">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-center mb-8">💬 What Students & Parents Say</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
            @foreach([
                'Excellent teaching! My son got 9 in GCSE Maths.' => 'Mrs. Patel, UK',
                'The online NEET prep is very structured!' => 'Ramesh, India',
                'Best SAT prep we’ve tried. Very responsive tutors.' => 'Diana, USA'
            ] as $quote => $author)
            <div class="rounded-xl shadow-lg p-6 flex flex-col justify-center {{ ['bg-amber-50','bg-lime-50','bg-emerald-50','bg-orange-50','bg-stone-50'][$loop->index % 5] }}">
                <p class="italic text-base mb-4">“{{ $quote }}”</p>
                <p class="text-gray-800 font-medium">— {{ $author }}</p>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-6 space-x-4">
            <a href="#" class="btn btn-primary btn-sm">📺 Watch Video Testimonials</a>
            <a href="/{{ $country }}/testimonials" class="btn btn-outline btn-sm">📚 Read More Reviews</a>
        </div>
    </div>
</section>

{{-- Gallery Preview --}}
<section class="relative py-16 border-t border-gray-200 bg-cover bg-center" style="background-image:url('/images/gallery-bg.jpg')">
    <div class="absolute inset-0 bg-white/60"></div>
    <div class="relative container mx-auto px-4">
    <h1 class="text-4xl font-bold text-center mb-8">📸 Our Journey in Pictures</h1>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach(['/images/classroom.jpg','/images/online.jpg','/images/lab.jpg','/images/awards.jpg'] as $img)
            <img src="{{ $img }}" class="w-full h-64 object-cover rounded cursor-pointer" alt="Gallery">
        @endforeach
    </div>
    <div class="text-center mt-6">
        <a href="/{{ $country }}/gallery" class="btn btn-outline btn-sm">🖼️ View Full Gallery</a>
    </div>
</section>

{{-- Quick Inquiry --}}
<section class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 py-[5vh] text-white text-sm">
    <div class="container mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
        <div>
            <h1 class="text-[2.618rem] font-bold mb-6">📩 Get in Touch or Book a Free Demo</h1>
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif<p class="text-lg mb-4">We’ll respond within 24&nbsp;hours.</p><ul class="list-disc list-inside space-y-2 text-base"><li>Personalised study plan</li><li>Free demo session</li><li>24×7 doubt support</li></ul></div>
        <div class="bg-white rounded-xl shadow-lg p-6 text-gray-900"><form id="inquiryForm" method="POST" action="{{ route('inquiry.submit', $country) }}" class="space-y-4">
            @csrf
            <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" class="w-full p-3 rounded {{ $errors->has('name') ? 'border border-red-400' : '' }} text-gray-900" required>
            @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" class="w-full p-3 rounded {{ $errors->has('email') ? 'border border-red-400' : '' }} text-gray-900" required>
            @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            <input type="tel" name="phone" placeholder="Phone" value="{{ old('phone') }}" class="w-full p-3 rounded {{ $errors->has('phone') ? 'border border-red-400' : '' }} text-gray-900">
            @error('phone')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            <textarea name="message" rows="4" placeholder="Message" class="w-full p-3 rounded {{ $errors->has('message') ? 'border border-red-400' : '' }} text-gray-900">{{ old('message') }}</textarea>
            @error('message')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            <div class="flex items-center">
                <input type="checkbox" id="agree" class="mr-2" required>
                <label for="agree" class="text-sm">I agree to be contacted</label>
            </div>
            <div id="inquiryResult" class="hidden mb-4"></div>
            <button type="submit" class="btn btn-primary w-full">📨 Submit Inquiry</button>
        </form></div>
    </div>
</section>
@push('scripts')
<script>
 document.addEventListener('DOMContentLoaded', () => {
   const form = document.getElementById('inquiryForm');
   if (!form) return;
   const resultBox = document.getElementById('inquiryResult');

    // MacBook Dock-style real-time scaling based on cursor position
    const container = document.querySelector('.card-container');
    if(container){
      const cards = Array.from(container.querySelectorAll('.course-card'));
      const maxScale = 1.1;
      const influence = 150; // pixels
      function scaleCards(e){
        const rect = container.getBoundingClientRect();
        const mouseX = e.clientX;
        cards.forEach(card =>{
          const cardRect = card.getBoundingClientRect();
          const cardCenter = cardRect.left + cardRect.width/2;
          const dist = Math.abs(mouseX - cardCenter);
          const scale = Math.max(1, maxScale - (dist / influence)*(maxScale-1));
          card.style.transform = `scale(${scale})`;
        });
      }
      function reset(){
        cards.forEach(c=>c.style.transform='scale(1)');
      }
      container.addEventListener('mousemove', scaleCards);
      container.addEventListener('mouseleave', reset);
    }

   form.addEventListener('submit', async (e) => {
     e.preventDefault();
     resultBox.classList.add('hidden');
     resultBox.textContent = '';
     form.querySelectorAll('.border-red-400').forEach(el => el.classList.remove('border-red-400'));
     form.querySelectorAll('p.text-red-600').forEach(el => el.remove());
     const submitBtn = form.querySelector('button[type="submit"]');
     submitBtn.disabled = true;
     submitBtn.classList.add('opacity-60');
     const fd = new FormData(form);
     try {
       const res = await fetch(form.action, {
         method: 'POST',
         headers: {
           'Accept': 'application/json',
           'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
         },
         body: fd
       });
       if (res.ok) {
         const data = await res.json();
         form.reset();
         resultBox.className = 'bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4';
         resultBox.textContent = data.message || 'Thank you!';
         resultBox.classList.remove('hidden');
       } else if (res.status === 422) {
         const data = await res.json();
         const errors = data.errors || {};
         Object.entries(errors).forEach(([field,msgs]) => {
           const input = form.querySelector(`[name="${field}"]`);
           if (input) {
             input.classList.add('border-red-400');
             const p = document.createElement('p');
             p.className = 'text-red-600 text-sm mt-1';
             p.textContent = msgs[0];
             input.insertAdjacentElement('afterend', p);
           }
         });
       } else {
         resultBox.className = 'bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded mb-4';
         resultBox.textContent = 'Sorry, something went wrong. Please try again.';
         resultBox.classList.remove('hidden');
       }
     } catch(err) {
       resultBox.className = 'bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded mb-4';
       resultBox.textContent = 'Network error. Please check your connection.';
       resultBox.classList.remove('hidden');
     } finally {
       submitBtn.disabled = false;
       submitBtn.classList.remove('opacity-60');
     }
   });
 });
</script>
@endpush

@endsection
