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
</style>
@endpush

@section('content')
{{-- Sign In Section --}}
<section class="bg-gray-50 min-h-[calc(100vh-7.5rem)] flex items-center justify-center text-gray-900 text-sm">
    <div class="max-w-4xl w-full flex flex-col md:flex-row rounded-2xl shadow-xl overflow-hidden">
        <!-- Left: Info -->
        <div class="hidden md:flex md:w-1/3 flex-col items-center justify-center p-10 bg-gradient-to-br from-purple-500 via-indigo-500 to-blue-600 text-white space-y-6" data-aos="fade" data-aos-duration="700" data-aos-delay="150">
            <img src="/images/login avatar.png" alt="Avatar" class="w-28 h-28 avatar-float" />
            <div class="text-center max-w-xs">
            <div>
                <h3 class="font-semibold text-lg mb-2">Welcome Back Learner!</h3>
                <p class="text-sm opacity-90">Log in to access your personalised dashboard and track your progress.</p>
            </div>
        </div>
        </div>
        <div class="w-full md:w-2/3 bg-white p-8 text-gray-900 auth-form" data-aos="fade" data-aos-duration="700" data-aos-delay="400">
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <input id="email-address" name="email" type="email" autocomplete="email" required class="w-full p-3 rounded {{ $errors->has('email') ? 'border border-red-400' : 'border border-gray-300' }} text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600" placeholder="Email address" value="{{ old('email') }}">
                @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                
                <input id="password" name="password" type="password" autocomplete="current-password" required class="w-full p-3 rounded {{ $errors->has('password') ? 'border border-red-400' : 'border border-gray-300' }} text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600" placeholder="Password">
                @error('password')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">Remember me</label>
                    </div>
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-medium text-blue-600 hover:text-blue-500">Forgot password?</a>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary w-full">Sign In</button>
            </form>
            
            <p class="mt-6 text-center text-sm text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">Sign Up</a>
            </p>
        </div>
    </div>
</section>
@endsection
