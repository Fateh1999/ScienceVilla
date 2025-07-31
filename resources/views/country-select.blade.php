@extends('layouts.app')

@section('content')
<section class="flex items-center justify-center py-24 bg-[radial-gradient(circle,_#e5e7eb_1.5px,_transparent_1.5px)] [background-size:32px_32px]">
<div class="container mx-auto px-4 py-8 text-center">
    <h1 class="text-5xl font-bold mb-4">Welcome to Science Villa</h1>
    <p class="text-xl mb-8">Please choose your country</p>
    <div class="flex flex-wrap justify-center gap-8 max-w-6xl mx-auto">
        @foreach([
            ['code'=>'in','name'=>'India','flag'=>'🇮🇳'],
            ['code'=>'uk','name'=>'United Kingdom','flag'=>'🇬🇧'],
            ['code'=>'us','name'=>'United States','flag'=>'🇺🇸'],
            ['code'=>'ca','name'=>'Canada','flag'=>'🇨🇦'],
            ['code'=>'au','name'=>'Australia','flag'=>'🇦🇺'],
        ] as $c)
        <a href="/{{ $c['code'] }}" class="p-10 bg-white rounded-xl shadow-lg hover:shadow-xl transition aspect-square w-72 flex flex-col items-center justify-center">
            <span class="text-7xl">{{ $c['flag'] }}</span>
            <p class="mt-4 text-2xl font-semibold">{{ $c['name'] }}</p>
        </a>
        @endforeach
    </div>
</div>
</section>
@endsection
