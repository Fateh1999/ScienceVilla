<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Fateh Science Villa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white">
            <div class="p-4">
                <h2 class="text-xl font-bold">Fateh Science Villa Admin</h2>
                <p class="text-sm text-gray-300">Welcome, {{ Auth::user()->name }}</p>
            </div>
            
            <nav class="mt-8">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="bi bi-speedometer2 mr-3"></i>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.users') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.users*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="bi bi-people mr-3"></i>
                    Users
                </a>
                
                <a href="{{ route('admin.courses') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.courses*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="bi bi-book mr-3"></i>
                    Courses
                </a>
                
                <a href="{{ route('admin.analytics') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.analytics') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="bi bi-graph-up mr-3"></i>
                    Analytics
                </a>
                
                <div class="border-t border-gray-700 mt-4 pt-4">
                    <a href="{{ route('home', ['country' => Auth::user()->country ?? 'in']) }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white">
                        <i class="bi bi-house mr-3"></i>
                        Back to Site
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline w-full">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white">
                            <i class="bi bi-box-arrow-right mr-3"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4">
                    <h1 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                </div>
            </header>
            
            <!-- Content -->
            <main class="flex-1 p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>
