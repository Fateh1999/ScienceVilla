@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-purple-50 via-white to-blue-50 py-16">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl lg:text-5xl font-extrabold text-center bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent mb-4" data-aos="fade-down">
            🏆 Recent Achievers
        </h1>
        <p class="text-center text-lg text-gray-600 mb-12 max-w-2xl mx-auto" data-aos="fade-down" data-aos-delay="100">
            Celebrating excellence! Here are some of our star performers across various exams and boards.
        </p>

        <!-- Achievers Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach([
                ['name'=>'Aarav Sharma','exam'=>'NEET','score'=>'655/720','avatar'=>'/images/topper1.jpg'],
                ['name'=>'Mia Patel','exam'=>'CBSE Class 12','score'=>'97.6%','avatar'=>'/images/topper2.jpg'],
                ['name'=>'Ryan Lee','exam'=>'SAT','score'=>'1560/1600','avatar'=>'/images/topper3.jpg'],
                ['name'=>'Zara Khan','exam'=>'ICSE Class 10','score'=>'98.4%','avatar'=>'/images/topper4.jpg'],
                ['name'=>'Liam Chen','exam'=>'JEE Main','score'=>'99.12 %ile','avatar'=>'/images/topper1.jpg'],
                ['name'=>'Sofia Gomez','exam'=>'IGCSE','score'=>'A* in 8 subjects','avatar'=>'/images/topper2.jpg'],
            ] as $idx=>$s)
            <div class="relative bg-white/90 backdrop-blur-md rounded-3xl shadow-xl p-8 flex flex-col items-center text-center" data-aos="zoom-in" data-aos-delay="{{ 100+$idx*50 }}">
                <img src="{{ $s['avatar'] }}" alt="{{ $s['name'] }}" class="w-28 h-28 object-cover rounded-full ring-4 ring-purple-200 mb-4">
                <h3 class="text-xl font-semibold mb-1">{{ $s['name'] }}</h3>
                <p class="text-purple-600 font-medium mb-2">{{ $s['exam'] }}</p>
                <p class="text-gray-700 text-lg font-bold">{{ $s['score'] }}</p>
                <!-- confetti animation badge -->
                <span class="absolute -top-4 -right-4 bg-emerald-500 text-white text-sm font-semibold px-3 py-1 rounded-full shadow-lg animate-pulse">Top {{ $loop->iteration }}</span>
            </div>
            @endforeach
        </div>

        <!-- Call to Action -->
        <div class="text-center mt-16" data-aos="fade-up">
            <a href="/{{ $country }}/contact" class="inline-block px-8 py-4 rounded-full bg-gradient-to-r from-purple-600 to-blue-600 text-white font-semibold shadow-lg transform hover:scale-105 transition-transform duration-300">
                Start Your Success Journey →
            </a>
        </div>
    </div>
</div>
@endsection
