@extends('layouts.student')

@section('title', 'Edit Profile')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-lg shadow-sm border p-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Profile</h1>

    @if ($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 rounded p-4 text-sm text-red-700">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('student.profile.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700">Full Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Email Address</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
            <input type="date" name="dob" value="{{ old('dob', $user->dob ? \Carbon\Carbon::parse($user->dob)->format('Y-m-d') : '') }}"
                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Country</label>
            <select name="country" required
                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @foreach($countries as $code => $name)
                    <option value="{{ $code }}" {{ old('country', $user->country) == $code ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('student.profile') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save Changes</button>
        </div>
    </form>
</div>
@endsection
