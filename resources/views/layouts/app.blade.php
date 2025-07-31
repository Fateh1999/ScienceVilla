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
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <a href="/{{ $country }}" class="text-xl font-bold text-blue-600">Science Villa</a>
            <nav class="hidden md:flex space-x-6 text-sm">
                <a href="/{{ $country }}" class="hover:text-blue-600">Home</a>
                <a href="/{{ $country }}/about" class="hover:text-blue-600">About Us</a>
                <a href="/{{ $country }}/courses" class="hover:text-blue-600">Courses</a>
                <a href="/{{ $country }}/results" class="hover:text-blue-600">Results</a>
                <a href="/{{ $country }}/gallery" class="hover:text-blue-600">Gallery</a>
                <a href="/{{ $country }}/testimonials" class="hover:text-blue-600">Testimonials</a>
                <a href="/{{ $country }}/blog" class="hover:text-blue-600">Blog</a>
                <a href="/{{ $country }}/contact" class="hover:text-blue-600">Contact Us</a>
            </nav>
            <!-- Country Switcher -->
            <div class="relative">
                <select id="countrySwitcher" class="border rounded p-1 text-sm" onchange="location = this.value;">
                    @foreach(['in'=>'🇮🇳','uk'=>'🇬🇧','us'=>'🇺🇸','ca'=>'🇨🇦','au'=>'🇦🇺'] as $code=>$flag)
                        <option value="/{{ $code }}" {{ ($country??'')==$code ? 'selected' : '' }}>{{ $flag }} {{ strtoupper($code) }}</option>
                    @endforeach
                </select>
            </div>
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
