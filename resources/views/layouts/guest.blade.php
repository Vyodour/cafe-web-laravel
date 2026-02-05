<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            [x-cloak] { display: none !important; }
            body { font-family: 'Outfit', sans-serif; }
        </style>
    </head>
    <body class="font-sans antialiased text-stone-900 dark:text-stone-100">
        <div x-data="{ videoLoaded: false }" class="relative min-h-screen flex flex-col justify-center items-center overflow-hidden">
            
            <!-- Skeleton Loading State -->
            <div x-show="!videoLoaded" 
                 class="absolute inset-0 bg-stone-200 dark:bg-stone-900 animate-pulse z-30 flex items-center justify-center transition-opacity duration-700">
                <div class="text-center">
                    <div class="w-16 h-16 border-4 border-amber-500 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
                </div>
            </div>

            <!-- Video Background Container -->
            <div class="absolute inset-0 z-0" x-show="videoLoaded" x-transition.opacity.duration.1000ms>
                <video autoplay muted loop playsinline 
                       class="absolute w-full h-full object-cover px-0 py-0"
                       @canplaythrough="videoLoaded = true">
                    <source src="{{ asset('video/video.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                
                <!-- Grid Pattern Overlay -->
                <div class="absolute inset-0 z-10 opacity-30 dark:opacity-40 pointer-events-none mix-blend-overlay"
                     style="background-image: linear-gradient(to right, #78350f 1px, transparent 1px), linear-gradient(to bottom, #78350f 1px, transparent 1px); background-size: 40px 40px;">
                </div>
                
                <!-- Dark Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-br from-stone-950/80 via-stone-900/60 to-stone-950/80 z-10"></div>
            </div>

            <!-- Content Container -->
            <div x-show="videoLoaded"
                 x-transition:enter="transition ease-out duration-700 delay-200"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="relative z-20 w-full sm:max-w-md px-6 py-4">
                 
                <!-- Logo -->
                <div class="flex justify-center mb-8">
                    <a href="/" class="text-3xl font-bold tracking-tighter text-white drop-shadow-md hover:scale-105 transition-transform">
                        Web<span class="text-amber-500">Kafe.</span>
                    </a>
                </div>

                <!-- Glassmorphism Card -->
                <div class="backdrop-blur-xl bg-white/10 dark:bg-stone-950/40 border border-white/20 dark:border-stone-700/30 shadow-2xl rounded-2xl p-8 overflow-hidden">
                    {{ $slot }}
                </div>
                
                <div class="mt-8 text-center text-sm text-stone-300">
                    &copy; {{ date('Y') }} WebKafe. All rights reserved.
                </div>
            </div>
        </div>
    </body>
</html>
