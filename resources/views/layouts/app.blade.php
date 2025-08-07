<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Science Villa' }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
    @stack('styles')
</head>
@php($country = $country ?? '')
<body class="min-h-screen flex flex-col font-sans bg-gray-50 text-gray-900">
    <!-- Navigation -->
    <header class="bg-white shadow-md sticky top-0 z-50 relative">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <a href="/{{ $country }}" class="text-xl font-bold text-blue-600">Science Villa</a>
            <!-- Mobile menu button -->
            <button id="mobileMenuBtn" class="xl:hidden text-2xl text-blue-600 focus:outline-none transition-transform duration-300">
                <i id="mobileMenuIcon" class="bi bi-list transition-transform duration-300"></i>
            </button>
            <nav class="hidden xl:flex space-x-6 text-sm">
                <a href="/{{ $country }}" class="text-gray-900 hover:text-blue-600">Home</a>
                <a href="/{{ $country }}/about" class="text-gray-900 hover:text-blue-600">About Us</a>
                <a href="/{{ $country }}/courses" class="text-gray-900 hover:text-blue-600">Courses</a>
                <a href="/{{ $country }}/results" class="text-gray-900 hover:text-blue-600">Results</a>
                <a href="/{{ $country }}/gallery" class="text-gray-900 hover:text-blue-600">Gallery</a>
                <a href="/{{ $country }}/testimonials" class="text-gray-900 hover:text-blue-600">Testimonials</a>
                <a href="/{{ $country }}/blog" class="text-gray-900 hover:text-blue-600">Blog</a>
                <a href="/{{ $country }}/contact" class="text-gray-900 hover:text-blue-600">Contact Us</a>
                
            </nav>
            <div class="hidden xl:flex items-center space-x-4 text-sm">
                @auth
                    <span class="text-gray-700">Hi, {{ Auth::user()->name }}!</span>
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
            <a href="/{{ $country }}" class="hover:text-blue-200">Home</a>
            <a href="/{{ $country }}/about" class="hover:text-blue-200">About Us</a>
            <a href="/{{ $country }}/courses" class="hover:text-blue-200">Courses</a>
            <a href="/{{ $country }}/results" class="hover:text-blue-200">Results</a>
            <a href="/{{ $country }}/gallery" class="hover:text-blue-200">Gallery</a>
            <a href="/{{ $country }}/testimonials" class="hover:text-blue-200">Testimonials</a>
            <a href="/{{ $country }}/blog" class="hover:text-blue-200">Blog</a>
            <a href="/{{ $country }}/contact" class="hover:text-blue-200">Contact Us</a>
            <div class="flex items-center space-x-3 pt-2 border-t">
                @auth
                    <span class="text-gray-700 text-center flex-1">Hi, {{ Auth::user()->name }}!</span>
                    <form method="POST" action="{{ route('logout') }}" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full px-4 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">Logout</button>
                    </form>
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
            © {{ date('Y') }} Science Villa | Designed with ❤️
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
