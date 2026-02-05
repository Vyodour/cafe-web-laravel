@extends('layouts.public')

@section('content')
<div x-data="{ videoLoaded: false }" class="relative w-full h-screen overflow-hidden">
    
    <div x-show="!videoLoaded" 
         class="absolute inset-0 bg-stone-200 dark:bg-stone-900 animate-pulse z-20 flex items-center justify-center transition-opacity duration-700">
        <div class="text-center">
            <div class="w-16 h-16 border-4 border-amber-500 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
            <p class="text-stone-500 dark:text-stone-400 font-medium tracking-wide">Loading Experience...</p>
        </div>
    </div>

    <div class="absolute inset-0 z-0" x-show="videoLoaded" x-transition.opacity.duration.1000ms>
        <video autoplay muted loop playsinline 
               class="absolute w-full h-full object-cover"
               @canplaythrough="videoLoaded = true">
            <source src="{{ asset('video/video.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <div class="absolute inset-0 z-10 opacity-30 dark:opacity-40 pointer-events-none mix-blend-overlay"
             style="background-image: linear-gradient(to right, #78350f 1px, transparent 1px), linear-gradient(to bottom, #78350f 1px, transparent 1px); background-size: 40px 40px;">
        </div>

        <div class="absolute inset-0 bg-gradient-to-t from-stone-950/90 via-stone-900/40 to-stone-900/30 z-10"></div>
    </div>

    <div class="relative z-20 h-full flex flex-col items-center justify-center text-center px-4"
         x-show="videoLoaded" 
         x-transition:enter="transition ease-out duration-1000 delay-300"
         x-transition:enter-start="opacity-0 translate-y-10"
         x-transition:enter-end="opacity-100 translate-y-0">
         
        <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 tracking-tight drop-shadow-lg">
            Rasakan <span class="text-amber-400">Kehangatan</span> <br>
            Dalam Setiap Tegukan
        </h1>
        
        <p class="text-lg md:text-xl text-stone-200 mb-10 max-w-2xl font-light leading-relaxed drop-shadow-md">
            Menghadirkan biji kopi pilihan nusantara dengan suasana yang nyaman 
            untuk bekerja, bersantai, dan bercerita.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="#cafes" class="px-8 py-3 bg-amber-600 hover:bg-amber-700 text-white rounded-full font-semibold transition-all transform hover:scale-105 shadow-lg hover:shadow-amber-500/20 hover-target">
                Jelajahi Outlet
            </a>
            <a href="{{ route('public.cafes.index') }}" class="px-8 py-3 bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/30 text-white rounded-full font-semibold transition-all hover-target">
                Lihat Menu
            </a>
        </div>
    </div>
    
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 z-20 animate-bounce" x-show="videoLoaded">
        <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</div>

<section id="cafes" class="py-24 bg-white dark:bg-stone-950 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-stone-300 dark:via-stone-700 to-transparent"></div>
    
    <div class="container mx-auto px-6 max-w-7xl">
        <div class="text-center mb-16">
            <span class="text-amber-600 dark:text-amber-500 font-medium tracking-wider uppercase text-sm mb-2 block">Lokasi Kami</span>
            <h2 class="text-3xl md:text-4xl font-bold text-stone-900 dark:text-white mb-4">Outlet Pilihan</h2>
            <div class="w-20 h-1 bg-amber-500 mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($cafes as $cafe)
                <a href="{{ route('public.cafes.show', $cafe->slug) }}" class="group relative block h-96 rounded-2xl overflow-hidden hover-target shadow-xl shadow-stone-200/50 dark:shadow-none">
                    <div class="absolute inset-0 bg-stone-200 dark:bg-stone-800">
                         <img src="{{ $cafe->image_url }}" alt="{{ $cafe->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    </div>
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    
                    <div class="absolute bottom-0 left-0 p-8 w-full translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                        <div class="flex gap-2 mb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">
                            @foreach($cafe->tags->take(2) as $tag)
                                <span class="px-2 py-1 text-xs bg-amber-500/20 text-amber-300 border border-amber-500/30 rounded-md backdrop-blur-sm">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">{{ $cafe->name }}</h3>
                        <p class="text-stone-300 line-clamp-2 text-sm">{{ $cafe->address }}</p>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-stone-500 dark:text-stone-400">Belum ada outlet yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-16 text-center">
             <a href="{{ route('public.cafes.index') }}" class="inline-flex items-center gap-2 text-amber-700 dark:text-amber-500 font-semibold hover:text-amber-900 dark:hover:text-amber-300 transition-colors hover-target group">
                Lihat Semua Lokasi
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
             </a>
        </div>
    </div>
</section>

<section class="py-24 bg-stone-50 dark:bg-stone-900/50">
    <div class="container mx-auto px-6 max-w-7xl">
         <div class="flex flex-col md:flex-row justify-between items-end mb-12">
            <div>
                <span class="text-amber-600 dark:text-amber-500 font-medium tracking-wider uppercase text-sm mb-2 block">Menu Favorit</span>
                <h2 class="text-3xl md:text-4xl font-bold text-stone-900 dark:text-white">Rekomendasi Hari Ini</h2>
            </div>
            <a href="{{ route('public.cafes.index') }}" class="hidden md:block px-6 py-2 rounded-full border border-stone-300 dark:border-stone-700 text-stone-600 dark:text-stone-300 hover:bg-stone-100 dark:hover:bg-stone-800 transition-colors hover-target">
                Lihat Menu Lengkap
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($featuredProducts as $product)
                <div class="bg-white dark:bg-stone-800 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow group">
                    <div class="relative aspect-square overflow-hidden bg-stone-200 dark:bg-stone-700">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    </div>
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-bold text-stone-900 dark:text-white line-clamp-1">{{ $product->name }}</h3>
                            <span class="text-amber-600 dark:text-amber-500 font-semibold text-sm">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        </div>
                        <p class="text-stone-500 dark:text-stone-400 text-sm line-clamp-2 mb-4 h-10">{{ $product->description }}</p>
                        <button class="w-full py-2 bg-stone-100 dark:bg-stone-700 text-stone-900 dark:text-stone-200 rounded-lg text-sm font-medium hover:bg-amber-500 hover:text-white dark:hover:bg-amber-600 transition-colors hover-target">
                            Add to Cart
                        </button>
                    </div>
                </div>
            @empty
                 <div class="col-span-full text-center py-12">
                    <p class="text-stone-500 dark:text-stone-400">Belum ada menu rekomendasi.</p>
                </div>
            @endforelse
        </div>
        
         <div class="mt-8 text-center md:hidden">
            <a href="{{ route('public.cafes.index') }}" class="px-6 py-2 rounded-full border border-stone-300 dark:border-stone-700 text-stone-600 dark:text-stone-300 hover:bg-stone-100 dark:hover:bg-stone-800 transition-colors hover-target">
                Lihat Menu Lengkap
            </a>
        </div>
    </div>
</section>
@endsection
