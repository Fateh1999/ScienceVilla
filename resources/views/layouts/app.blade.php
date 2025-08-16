<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Fateh Science Villa' }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
    @stack('styles')
    @php
        $country = $country ?? '';
        $currentPath = request()->path();
        $currentRoute = request()->route() ? request()->route()->getName() : '';
    @endphp
</head>
<body class="min-h-screen flex flex-col font-sans bg-gray-50 text-gray-900">
    <!-- Navigation -->
    <header class="bg-white shadow-md sticky top-0 z-50 relative">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <a href="/{{ $country }}" class="text-xl font-bold text-blue-600">Fateh Science Villa</a>
            <!-- Mobile menu button -->
            <button id="mobileMenuBtn" class="xl:hidden text-2xl text-blue-600 focus:outline-none transition-transform duration-300">
                <i id="mobileMenuIcon" class="bi bi-list transition-transform duration-300"></i>
            </button>
            <nav class="hidden xl:flex space-x-6 text-sm">
                
                <a href="/{{ $country }}" class="{{ ($currentRoute === 'home' || $currentPath === $country || $currentPath === $country.'/' || $currentPath === '') ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-1' : 'text-gray-900 hover:text-blue-600' }}">Home</a>
                <a href="/{{ $country }}/about" class="{{ (strpos($currentPath, '/about') !== false) ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-1' : 'text-gray-900 hover:text-blue-600' }}">About Us</a>
                
                <!-- Courses Dropdown -->
                <div class="relative group">
                    <a href="/{{ $country }}/courses" class="{{ (strpos($currentPath, '/courses') !== false || strpos($currentPath, '/cocurricular') !== false || strpos($currentPath, '/course-detail') !== false) ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-1' : 'text-gray-900 hover:text-blue-600' }} flex items-center gap-1">
                        Courses
                        <i class="bi bi-chevron-down text-xs transition-transform group-hover:rotate-180"></i>
                    </a>
                    <div class="absolute top-full left-0 mt-1 w-48 bg-white border border-gray-200 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="py-2">
                            <a href="/{{ $country }}/courses" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                <i class="bi bi-book mr-2"></i>Academic Courses
                            </a>
                            <a href="/{{ $country }}/cocurricular" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                <i class="bi bi-palette mr-2"></i>Co-Curricular Activities
                            </a>
                        </div>
                    </div>
                </div>
                
                <a href="/{{ $country }}/results" class="{{ (strpos($currentPath, '/results') !== false) ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-1' : 'text-gray-900 hover:text-blue-600' }}">Results</a>
                <a href="/{{ $country }}/gallery" class="{{ (strpos($currentPath, '/gallery') !== false) ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-1' : 'text-gray-900 hover:text-blue-600' }}">Gallery</a>
                <a href="/{{ $country }}/testimonials" class="{{ (strpos($currentPath, '/testimonials') !== false) ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-1' : 'text-gray-900 hover:text-blue-600' }}">Testimonials</a>
                <a href="/{{ $country }}/blog" class="{{ (strpos($currentPath, '/blog') !== false) ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-1' : 'text-gray-900 hover:text-blue-600' }}">Blog</a>
                <a href="/{{ $country }}/contact" class="{{ (strpos($currentPath, '/contact') !== false) ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-1' : 'text-gray-900 hover:text-blue-600' }}">Contact Us</a>
                
            </nav>
            <div class="hidden xl:flex items-center space-x-4 text-sm">
                @auth
                    <a href="{{ route('student.dashboard') }}" class="px-3 py-1 border border-blue-600 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded transition">Hi, {{ Auth::user()->name }}!</a>
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200 transition text-xs">Admin</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">Logout</button>
                    </form>
                @else
                    <a href="{{ $country ? '/'.$country.'/login' : '/login' }}" class="px-4 py-1 border border-blue-600 text-blue-600 rounded hover:bg-blue-50 transition">Sign In</a>
                    <a href="{{ $country ? '/'.$country.'/register' : '/register' }}" class="px-4 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Sign Up</a>
                @endauth
                <select id="countrySwitcher" class="border rounded p-1 text-sm" onchange="location = this.value;">
                @foreach(['in'=>'🇮🇳','uk'=>'🇬🇧','us'=>'🇺🇸','ca'=>'🇨🇦','au'=>'🇦🇺'] as $code=>$flag)
                    <option value="/{{ $code }}" {{ ($country??'')==$code ? 'selected' : '' }}>{{ $flag }} {{ strtoupper($code) }}</option>
                @endforeach
            </select>
            </div>
        </div>
    <!-- Mobile nav -->
    <div id="mobileNav" class="absolute top-full right-4 xl:right-6 w-72 max-w-full xl:hidden bg-white/50 backdrop-blur-lg border border-white/60 rounded-xl opacity-0 scale-95 -translate-y-4 pointer-events-none transition-all duration-300 shadow-lg opacity-0 scale-95 -translate-y-4 pointer-events-none transition-all duration-300 bg-white border-t shadow-lg">
        <nav class="flex flex-col space-y-3 p-4 text-sm">
            <a href="/{{ $country }}" class="{{ ($currentRoute === 'home' || $currentPath === $country || $currentPath === $country.'/' || $currentPath === '') ? 'text-blue-600 font-semibold' : 'hover:text-blue-200' }}">Home</a>
            <a href="/{{ $country }}/about" class="{{ (strpos($currentPath, '/about') !== false) ? 'text-blue-600 font-semibold' : 'hover:text-blue-200' }}">About Us</a>
            
            <!-- Mobile Courses Section -->
            <div class="space-y-2">
                <div class="{{ (strpos($currentPath, '/courses') !== false || strpos($currentPath, '/cocurricular') !== false || strpos($currentPath, '/course-detail') !== false) ? 'text-blue-600 font-semibold' : 'text-gray-700' }} font-medium">Courses</div>
                <div class="pl-4 space-y-2">
                    <a href="/{{ $country }}/courses" class="block text-gray-600 hover:text-blue-600 transition-colors">
                        <i class="bi bi-book mr-2"></i>Academic Courses
                    </a>
                    <a href="/{{ $country }}/cocurricular" class="block text-gray-600 hover:text-blue-600 transition-colors">
                        <i class="bi bi-palette mr-2"></i>Co-Curricular Activities
                    </a>
                </div>
            </div>
            
            <a href="/{{ $country }}/results" class="{{ (strpos($currentPath, '/results') !== false) ? 'text-blue-600 font-semibold' : 'hover:text-blue-200' }}">Results</a>
            <a href="/{{ $country }}/gallery" class="{{ (strpos($currentPath, '/gallery') !== false) ? 'text-blue-600 font-semibold' : 'hover:text-blue-200' }}">Gallery</a>
            <a href="/{{ $country }}/testimonials" class="{{ (strpos($currentPath, '/testimonials') !== false) ? 'text-blue-600 font-semibold' : 'hover:text-blue-200' }}">Testimonials</a>
            <a href="/{{ $country }}/blog" class="{{ (strpos($currentPath, '/blog') !== false) ? 'text-blue-600 font-semibold' : 'hover:text-blue-200' }}">Blog</a>
            <a href="/{{ $country }}/contact" class="{{ (strpos($currentPath, '/contact') !== false) ? 'text-blue-600 font-semibold' : 'hover:text-blue-200' }}">Contact Us</a>
            <div class="flex flex-col space-y-2 pt-2 border-t">
                @auth
                    <a href="{{ route('student.dashboard') }}" class="block px-4 py-1 border border-blue-600 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded transition text-center">Hi, {{ Auth::user()->name }}!</a>
                    <div class="flex items-center space-x-2">
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="flex-1 text-center px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200 transition text-xs">Admin Panel</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full px-4 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">Logout</button>
                        </form>
                    </div>
                @else
                    <a href="{{ $country ? '/'.$country.'/login' : '/login' }}" class="flex-1 text-center px-4 py-1 border border-blue-600 text-blue-600 rounded hover:bg-blue-50 transition">Sign In</a>
                    <a href="{{ $country ? '/'.$country.'/register' : '/register' }}" class="flex-1 text-center px-4 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Sign Up</a>
                @endauth
            </div>
            <select id="countrySwitcherMobile" class="border rounded p-1 text-sm w-full" onchange="location = this.value;">
                @foreach(['in'=>'🇮🇳','uk'=>'🇬🇧','us'=>'🇺🇸','ca'=>'🇨🇦','au'=>'🇦🇺'] as $code=>$flag)
                    <option value="/{{ $code }}" {{ ($country??'')==$code ? 'selected' : '' }}>{{ $flag }} {{ strtoupper($code) }}</option>
                @endforeach
            </select>
        </nav>
    </div>
</header>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-white py-6">
        <div class="container mx-auto px-4 text-center text-sm">
            © {{ date('Y') }} Fateh Science Villa | Designed with ❤️
        </div>
    </footer>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            AOS.init({ once: true, duration: 800, offset: 120 });
            // mobile menu toggle with icon animation
            const btn = document.getElementById('mobileMenuBtn');
            const mobileNav = document.getElementById('mobileNav');
            const icon = document.getElementById('mobileMenuIcon');
            // prepare mobile items for animation
            const mobileItems = document.querySelectorAll('#mobileNav a, #mobileNav select, #mobileNav div > a');
            mobileItems.forEach(el => el.classList.add('transition-all','duration-300','opacity-0','translate-y-2'));
            btn?.addEventListener('click', () => {
                const showing = !mobileNav.classList.contains('opacity-0');
                if(showing){
                    // hide container
                    mobileNav.classList.add('opacity-0','scale-95','-translate-y-4','pointer-events-none');
                    // hide items staggered reverse
                    mobileItems.forEach((el,i)=>{
                        setTimeout(()=>{
                            el.classList.add('opacity-0','translate-y-2');
                        }, (mobileItems.length - i)*40);
                    });
                }else{
                    mobileNav.classList.remove('opacity-0','scale-95','-translate-y-4','pointer-events-none');
                    // show items staggered
                    mobileItems.forEach((el,i)=>{
                        setTimeout(()=>{
                            el.classList.remove('opacity-0','translate-y-2');
                        }, i*40);
                    });
                }
                icon.classList.toggle('bi-list');
                icon.classList.toggle('bi-x');
                btn.classList.toggle('rotate-90');
            });
            // animate counters
            const counters = document.querySelectorAll('.counter');
            const speed = 40;
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if(entry.isIntersecting){
                        const el = entry.target;
                        const updateCount = () => {
                            const target = +el.dataset.count;
                            const count  = +el.innerText.replace(/\D/g,'');
                            const inc = Math.ceil(target / speed);
                            if(count < target){
                                el.innerText = count + inc + (el.dataset.percent ? '%' : '+');
                                setTimeout(updateCount, 30);
                            } else {
                                el.innerText = target + (el.dataset.percent ? '%' : '+');
                            }
                        };
                        updateCount();
                        observer.unobserve(el);
                    }
                })
            }, { threshold: 0.6 });
            counters.forEach(c=>observer.observe(c));
        });
    </script>
    @stack('scripts')
</body>
</html>
