@extends('layouts.app')

@section('content')
<section class="min-h-[80vh] flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white rounded-xl shadow-lg p-8">
        <div class="text-center space-y-2">
            <h2 class="mt-2 text-3xl font-extrabold text-gray-900">Forgot your password?</h2>
            <p class="mt-1 text-sm text-gray-600">Enter your email and we’ll send you a reset link.</p>
        </div>
        <form class="mt-8 space-y-6" method="POST" action="#">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="email" class="sr-only">Email address</label>
                    <input id="email" name="email" type="email" required class="appearance-none rounded relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-600 focus:border-blue-600 focus:z-10 sm:text-sm" placeholder="Email address">
                </div>
            </div>
            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Send Reset Link
                </button>
            </div>
        </form>
        <p class="mt-6 text-center text-sm text-gray-600">
            <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">Back to Sign In</a>
        </p>
    </div>
</section>
@endsection
