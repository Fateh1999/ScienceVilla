@extends('layouts.app')

@push('styles')
<style>
.auth-form { transition: transform 0.1s ease; }
.auth-form:hover { transform: scale(1.01); }
@keyframes float {
  0%   { transform: translate3d(0,0,0); }
  100% { transform: translate3d(0,-6px,0); }
}
.avatar-float {
  animation: float 1.5s ease-in-out infinite alternate;
  will-change: transform;
}
.btn-gradient {
  background-image: linear-gradient(to right, #4f46e5, #3b82f6, #06b6d4);
  background-size: 200% 100%;
  transition: background-position 0.4s ease;
}
.btn-gradient:hover { background-position: 100% 0; }
.auth-form:hover { transform: scale(1.02); }
</style>
@endpush

@section('content')
{{-- Sign Up Section --}}
<section class="bg-gray-50 min-h-[calc(100vh-7.5rem)] flex items-center justify-center text-gray-900 text-sm">
    <div class="max-w-4xl w-full flex flex-col md:flex-row rounded-2xl shadow-xl overflow-hidden">
        <!-- Left: Info -->
        <div class="hidden md:flex md:w-1/3 flex-col items-center justify-center p-10 bg-gradient-to-br from-pink-500 via-purple-500 to-indigo-500 text-white space-y-6" data-aos="fade" data-aos-duration="700" data-aos-delay="150">
            <img src="/images/login avatar.png" alt="Avatar" class="w-28 h-28 avatar-float" />
            <div class="text-center max-w-xs">
                <h3 class="font-semibold text-lg mb-2">Join Science Villa!</h3>
                <p class="text-sm opacity-90">Create an account to unlock courses and track your growth.</p>
            </div>
                <ul>
                <li>Track your academic progress</li>
                <li>Join a global community</li>
            </ul>
        </div>
        <div class="w-full md:w-2/3 bg-white p-8 text-gray-900 rounded-2xl shadow-md" data-aos="fade" data-aos-duration="700" data-aos-delay="400">
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <input id="name" name="name" type="text" required autofocus class="w-full p-3 rounded {{ $errors->has('name') ? 'border border-red-400' : 'border border-gray-300' }} text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-purple-600" placeholder="Full Name" value="{{ old('name') }}">
                @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                
                <input id="email" name="email" type="email" required class="w-full p-3 rounded {{ $errors->has('email') ? 'border border-red-400' : 'border border-gray-300' }} text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-purple-600" placeholder="Email address" value="{{ old('email') }}">
                @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                
                <input id="dob" name="dob" type="date" required class="w-full p-3 rounded {{ $errors->has('dob') ? 'border border-red-400' : 'border border-gray-300' }} text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-purple-600" value="{{ old('dob') }}">
                @error('dob')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                
                <input id="password" name="password" type="password" required class="w-full p-3 rounded {{ $errors->has('password') ? 'border border-red-400' : 'border border-gray-300' }} text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-purple-600" placeholder="Password">
                @error('password')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                
                <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full p-3 rounded border border-gray-300 text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-purple-600" placeholder="Confirm Password">
                
                <button type="submit" class="w-full py-3 text-white rounded btn-gradient">Create Account</button>
            </form>
            
            <p class="mt-6 text-center text-sm text-gray-600">
                Already have an account?
                <a href="{{ route('login') }}" class="font-medium text-purple-600 hover:text-purple-500">Sign In</a>
            </p>
        </div>
    </div>
</section>
@endsection
