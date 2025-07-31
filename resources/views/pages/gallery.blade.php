@extends('layouts.app')

@section('content')
<section class="relative py-24 bg-gradient-to-br from-purple-50 via-white to-blue-50 overflow-hidden">
    <!-- Decorative blobs -->
    <div class="absolute -top-20 -left-10 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
    <div class="absolute -bottom-20 -right-10 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>

    <div class="container mx-auto px-4">
        <h2 class="text-center text-4xl lg:text-5xl font-extrabold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-12" data-aos="fade-down">
            Gallery
        </h2>
        <p class="text-center max-w-2xl mx-auto text-gray-600 mb-16" data-aos="fade-up" data-aos-delay="100">
            Explore snapshots from our classrooms, labs, and events showcasing the vibrant learning environment at ScienceVilla.
        </p>

        <!-- Image Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4" data-aos="fade-up" data-aos-delay="200">
            @php($images = [
                'awards.jpg',
                'classroom.jpg',
                'hero.jpg',
                'lab.jpg',
                'online.jpg',
                'topper1.jpg',
                'topper2.jpg',
                'topper3.jpg',
                'topper4.jpg',
                'gallery-bg.jpg',
                'featured-bg.jpg',
            ])
            @foreach($images as $img)
            <a href="/images/{{ $img }}" class="relative block overflow-hidden rounded-xl shadow-md group glightbox" data-gallery="gallery">
                <img src="/images/{{ $img }}" alt="Gallery image" class="object-cover w-full h-40 sm:h-48 md:h-56 lg:h-60 transition-transform duration-300 group-hover:scale-110" loading="lazy">
                <span class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity"></span>
            </a>
            @endforeach
        </div>

        <!-- CTA -->
        <div class="text-center mt-20" data-aos="fade-up" data-aos-delay="300">
            <a href="/{{ $country }}/contact" class="inline-block px-10 py-4 rounded-full bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold shadow-lg transform hover:scale-105 transition-transform duration-300">
                Explore More →
            </a>
        </div>
    </div>
</section>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/glightbox/dist/css/glightbox.min.css" />
<style>
    .animate-blob {
        animation: blob 7s infinite;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    @keyframes blob {
        0%,100%{ transform: translate(0px,0px) scale(1); }
        33%{ transform: translate(30px,-20px) scale(1.1); }
        66%{ transform: translate(-20px,20px) scale(0.9); }
    }
    /* Reduce lightbox image size */
    .gslide-media img{ max-width:80%; max-height:80vh; border-radius: 1rem; }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/glightbox/dist/js/glightbox.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        GLightbox({ selector: '.glightbox', loop: true, touchNavigation: true });
    });
</script>
@endpush
