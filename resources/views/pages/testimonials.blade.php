@extends('layouts.app')

@section('content')
<section class="relative py-20 bg-gradient-to-b from-blue-50 via-white to-purple-50 overflow-hidden">
    <!-- Decorative Blobs -->
    <div class="absolute -top-20 -left-20 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
    <div class="absolute -bottom-20 -right-10 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>

    <div class="container mx-auto px-4">
        <h2 class="text-center text-4xl lg:text-5xl font-extrabold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-16" data-aos="fade-down">
            What Our Students Say
        </h2>

        <!-- Testimonials Alternating Layout -->
        <div class="max-w-5xl mx-auto space-y-12">
@php($testimonials=[
                ['name'=>'Aisha Singh','course'=>'Class 10 Science','quote'=>'Fateh Science Villa made complex topics so easy! I topped my class.','avatar'=>'/images/topper1.jpg','rating'=>5],
                ['name'=>'David Kumar','course'=>'NEET Prep','quote'=>'Amazing crash courses helped me score 650+. Highly recommend!','avatar'=>'/images/topper2.jpg','rating'=>5],
                ['name'=>'Sara Lee','course'=>'SAT Prep','quote'=>'Improved my score by 140 points in just 2 months.','avatar'=>'/images/topper3.jpg','rating'=>5],
                ['name'=>'Mohit Rao','course'=>'Class 12 Maths','quote'=>'Live sessions made calculus fun. Scored 98%!','avatar'=>'/images/topper4.jpg','rating'=>5],
                ['name'=>'Priya Sharma','course'=>'JEE Main','quote'=>'Daily practice tests boosted my confidence tremendously.','avatar'=>'/images/topper1.jpg','rating'=>5],
                ['name'=>'Alex Chen','course'=>'IGCSE Physics','quote'=>'Interactive videos made physics concepts crystal clear.','avatar'=>'/images/topper2.jpg','rating'=>5],
                ['name'=>'Ravi Patel','course'=>'Class 9 Chemistry','quote'=>'The animated experiments helped me understand reactions better.','avatar'=>'/images/topper3.jpg','rating'=>5],
                ['name'=>'Emma Wilson','course'=>'AP Biology','quote'=>'Detailed diagrams and quizzes made studying enjoyable.','avatar'=>'/images/topper4.jpg','rating'=>5],
                ['name'=>'Arjun Mehta','course'=>'CBSE Class 11','quote'=>'Personalized study plans kept me on track all year.','avatar'=>'/images/topper1.jpg','rating'=>5],
                ['name'=>'Lisa Zhang','course'=>'IB Mathematics','quote'=>'Step-by-step solutions saved me hours of confusion.','avatar'=>'/images/topper2.jpg','rating'=>5],
                ['name'=>'Karan Joshi','course'=>'ICSE Class 8','quote'=>'Fun learning games made studying feel like playing.','avatar'=>'/images/topper3.jpg','rating'=>5],
                ['name'=>'Maya Rodriguez','course'=>'A-Level Chemistry','quote'=>'Virtual labs gave me hands-on experience safely.','avatar'=>'/images/topper4.jpg','rating'=>5],
            ])
            @foreach($testimonials as $idx=>$t)
            <div class="flex flex-col lg:flex-row items-center gap-6 {{ $idx % 2 == 1 ? 'lg:flex-row-reverse' : '' }}" data-aos="fade-up" data-aos-delay="{{ $idx < 4 ? $idx*100 : 10+($idx-4)*150 }}">
                <!-- Avatar Side -->
                <div class="flex-shrink-0">
                    <div class="relative">
                        <img src="{{ !empty($t['avatar']) ? $t['avatar'] : '/images/user.png' }}" alt="{{ $t['name'] }}" class="w-20 h-20 lg:w-24 lg:h-24 object-cover rounded-full shadow-lg ring-3 ring-white">
                        <div class="absolute -bottom-1 -right-1 bg-gradient-to-r from-purple-500 to-blue-500 text-white px-2 py-1 rounded-full text-xs font-semibold shadow-md">
                            ⭐ {{ $t['rating'] }}
                        </div>
                    </div>
                </div>
                
                <!-- Content Side -->
                <div class="flex-1 text-center lg:text-left">
                    <div class="relative bg-white rounded-xl p-6 shadow-lg border border-gray-100">
                        <!-- Quote Icon -->
                        <svg class="absolute top-3 {{ $idx % 2 == 0 ? 'left-3' : 'right-3' }} w-6 h-6 text-blue-200" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z"/>
                        </svg>
                        
                        <blockquote class="text-base lg:text-lg text-gray-700 leading-relaxed mb-4 {{ $idx % 2 == 0 ? 'pl-8' : 'pr-8' }}">
                            "{{ $t['quote'] }}"
                        </blockquote>
                        
                        <div class="flex items-center {{ $idx % 2 == 0 ? 'justify-start' : 'justify-end lg:justify-start' }}">
                            <div class="{{ $idx % 2 == 1 ? 'text-right lg:text-left' : '' }}">
                                <h3 class="text-lg font-bold text-gray-900">{{ $t['name'] }}</h3>
                                <p class="text-blue-600 font-medium text-sm">{{ $t['course'] }}</p>
                                <div class="flex {{ $idx % 2 == 1 ? 'justify-end lg:justify-start' : '' }} mt-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="text-yellow-400 text-sm">★</span>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- CTA -->
        <div class="text-center mt-20" data-aos="fade-up" data-aos-delay="200">
            <a href="/{{ $country }}/contact" class="inline-block px-10 py-4 rounded-full bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold shadow-lg transform hover:scale-105 transition-transform duration-300">
                Join Our Success Stories →
            </a>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .animate-blob {
        animation: blob 7s infinite;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    @keyframes blob {
        0%,100%{ transform: translate(0px,0px) scale(1); }
        33%{ transform: translate(30px,-20px) scale(1.1); }
        66%{ transform: translate(-20px,20px) scale(0.9); }
    }
</style>
@endpush
            
