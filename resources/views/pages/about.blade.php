@extends('layouts.app')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet" />
<style>
    .parallax {
        background-image: url('/images/learning-hero.jpg');
        background-attachment: fixed;
        background-size: cover;
        background-position: center;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', ()=> AOS.init({ once:true, duration:700, easing:'ease-out-cubic'}));
</script>
@endpush



@section('content')
<!-- Hero Parallax Banner -->
<section class="parallax relative h-[60vh] flex items-center justify-center">
    <div class="absolute inset-0 bg-emerald-900/70 mix-blend-multiply"></div>
    <div class="relative z-10 text-center px-4" data-aos="fade-down">
        <h1 class="text-5xl font-extrabold text-white mb-4">Empowering Learners Globally</h1>
        <p class="max-w-2xl mx-auto text-lg text-emerald-100">Quality, curriculum-aligned education for students in India, UK, USA, Canada & Australia.</p>
    </div>
</section>

<!-- Global Curriculum -->
<section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-gray-800 text-center mb-12" data-aos="fade-up">Global Curriculum · Local Relevance</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8" data-aos="fade-up" data-aos-delay="150">
            @php
                $curricula=[
                    ['India','CBSE, ICSE'],
                    ['United Kingdom','GCSE, A-Levels (AQA, Edexcel)'],
                    ['United States','Common Core, NGSS, AP'],
                    ['Canada','Ontario & BC Curriculum'],
                    ['Australia','NSW, Victoria Curriculum']
                ];
            @endphp
            @foreach($curricula as [$countryName,$detail])
            <div class="bg-white border border-emerald-100/60 rounded-xl p-6 shadow-sm hover:shadow-md transition" data-aos="zoom-in" data-aos-delay="{{$loop->index*100}}">
                <h3 class="font-semibold text-emerald-700 mb-2">{{$countryName}}</h3>
                <p class="text-sm text-gray-600">{{$detail}}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Vision & Mission -->
<section class="py-20 bg-gradient-to-br from-emerald-50 to-lime-50">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-4xl font-bold text-gray-800 text-center mb-16" data-aos="fade-up">Our Purpose & Promise</h2>
        
        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Vision Card -->
            <div class="relative group" data-aos="fade-right">
                <div class="absolute inset-0 bg-gradient-to-r from-emerald-400 to-emerald-600 rounded-2xl transform rotate-1 group-hover:rotate-2 transition-transform duration-300"></div>
                <div class="relative bg-white p-8 rounded-2xl shadow-lg">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-3xl">🌟</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Our Vision</h3>
                    </div>
                    <p class="text-lg text-gray-700 leading-relaxed mb-4">To make quality education accessible to every learner, nurturing curiosity, confidence & academic excellence.</p>
                    <div class="text-sm text-emerald-600 font-medium">Regardless of geography or background</div>
                </div>
            </div>
            
            <!-- Mission Card -->
            <div class="relative group" data-aos="fade-left">
                <div class="absolute inset-0 bg-gradient-to-r from-lime-400 to-emerald-500 rounded-2xl transform -rotate-1 group-hover:-rotate-2 transition-transform duration-300"></div>
                <div class="relative bg-white p-8 rounded-2xl shadow-lg">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-lime-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-3xl">🚀</span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Our Mission</h3>
                    </div>
                    <div class="space-y-3">
                        @foreach([
                            'Deliver curriculum-aligned interactive learning experiences',
                            'Foster independent & guided pathways for Grades 8-12/13',
                            'Bridge traditional & modern learning with technology',
                            'Build concept clarity, exam confidence & real-world skills'
                        ] as $mission)
                        <div class="flex items-start">
                            <div class="w-2 h-2 bg-lime-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                            <p class="text-gray-700">{{$mission}}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Differentiators -->
<section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-gray-800 text-center mb-12" data-aos="fade-up">Why Science&nbsp;Villa?</h2>
        <div class="grid md:grid-cols-2 gap-10">
            @php
                $diff=[
                    ['👩‍🏫','Subject Experts','Certified educators from India & abroad'],
                    ['✨','Interactive Content','Crash courses, quizzes, summaries, past papers'],
                    ['🕑','Learn Anytime','Self-paced access on any device'],
                    ['🛠️','Personalised Pathways','Courses filtered by country, grade & subject']
                ];
            @endphp
            @foreach($diff as [$icon,$title,$desc])
            <div class="flex items-start" data-aos="fade-up" data-aos-delay="{{$loop->index*100}}">
                <div class="text-3xl mr-4">{{$icon}}</div>
                <div>
                    <h3 class="font-semibold text-gray-800 mb-1">{{$title}}</h3>
                    <p class="text-sm text-gray-600">{{$desc}}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>



<!-- Call to Action -->
<section class="py-20 bg-emerald-600 text-white text-center" data-aos="fade-up" data-aos-duration="1000">
    <h2 class="text-3xl font-bold mb-4">Join Our Global Learning Community</h2>
    <p class="mb-8 max-w-2xl mx-auto">Explore featured courses, take a free demo, and experience the Science&nbsp;Villa difference.</p>
    <a href="/courses" class="inline-block bg-white text-emerald-600 font-semibold px-6 py-3 rounded-full shadow-md hover:shadow-lg transition">Browse Courses</a>
</section>

@endsection
