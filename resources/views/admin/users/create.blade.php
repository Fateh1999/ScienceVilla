@extends('layouts.admin')

@section('title', 'Create User')

@section('content')
<div class="mb-6">
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.users') }}" class="text-gray-600 hover:text-gray-900">
            <i class="bi bi-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Create User</h1>
            <p class="text-gray-600">Add a new user to the system</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm border p-6">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" id="password" name="password" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                <select id="country" name="country" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('country') border-red-500 @enderror">
                    <option value="">Select Country</option>
                    <option value="in" {{ old('country') == 'in' ? 'selected' : '' }}>India</option>
                    <option value="uk" {{ old('country') == 'uk' ? 'selected' : '' }}>United Kingdom</option>
                    <option value="us" {{ old('country') == 'us' ? 'selected' : '' }}>United States</option>
                    <option value="ca" {{ old('country') == 'ca' ? 'selected' : '' }}>Canada</option>
                    <option value="au" {{ old('country') == 'au' ? 'selected' : '' }}>Australia</option>
                </select>
                @error('country')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6">
            <div class="flex items-center">
                <input type="checkbox" id="is_admin" name="is_admin" value="1" {{ old('is_admin') ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="is_admin" class="ml-2 block text-sm text-gray-900">
                    Grant admin privileges
                </label>
            </div>
            <p class="text-sm text-gray-500 mt-1">Admin users can access the admin panel and manage the system</p>
        </div>

        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.users') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Create User
            </button>
        </div>
    </form>
</div>
@endsection
