<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Dashboard') - Fateh Science Villa</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('student.dashboard') }}" class="flex items-center">
                        <span class="text-2xl font-bold text-blue-600">Fateh Science Villa</span>
                        <span class="ml-2 px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded">Student</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('student.dashboard') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('student.dashboard') ? 'text-blue-600 bg-blue-50' : '' }}">
                        <i class="bi bi-house-door mr-2"></i>Dashboard
                    </a>
                    <a href="{{ route('student.courses') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('student.courses') ? 'text-blue-600 bg-blue-50' : '' }}">
                        <i class="bi bi-book mr-2"></i>My Courses
                    </a>
                    <a href="{{ route('student.browse-courses') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('student.browse-courses') ? 'text-blue-600 bg-blue-50' : '' }}">
                        <i class="bi bi-search mr-2"></i>Browse Courses
                    </a>
                    <a href="{{ route('student.profile') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('student.profile') ? 'text-blue-600 bg-blue-50' : '' }}">
                         <i class="bi bi-person mr-2"></i>Profile
                     </a>
                     <a href="{{ url('/' . (Auth::user()->country ?? 'in')) }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                         <i class="bi bi-globe mr-2"></i>Website
                     </a>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- User Menu -->
                    <div class="relative">
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-700">Hello, {{ Auth::user()->name }}</span>
                            <div class="flex items-center space-x-2">
                                @if(Auth::user()->is_admin)
                                    <a href="{{ route('admin.dashboard') }}" class="text-red-600 hover:text-red-800 text-sm">
                                        <i class="bi bi-gear-fill mr-1"></i>Admin
                                    </a>
                                @endif
                                <form action="{{ route('logout') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-gray-600 hover:text-gray-800 text-sm">
                                        <i class="bi bi-box-arrow-right mr-1"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden border-t">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('student.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('student.dashboard') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600' }}">
                    <i class="bi bi-house-door mr-2"></i>Dashboard
                </a>
                <a href="{{ route('student.courses') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('student.courses') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600' }}">
                    <i class="bi bi-book mr-2"></i>My Courses
                </a>
                <a href="{{ route('student.browse-courses') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('student.browse-courses') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600' }}">
                    <i class="bi bi-search mr-2"></i>Browse Courses
                </a>
                <a href="{{ route('student.profile') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('student.profile') ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:text-blue-600' }}">
                     <i class="bi bi-person mr-2"></i>Profile
                 </a>
                 <a href="{{ url('/' . (Auth::user()->country ?? 'in')) }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600">
                     <i class="bi bi-globe mr-2"></i>Website
                 </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    <!-- Scripts -->
    <script>
        // CSRF token setup for AJAX requests
        window.Laravel = {
            csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };
    </script>
    @stack('scripts')
</body>
</html>
