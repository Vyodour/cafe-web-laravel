<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Web Kafe'))</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Alpine.js Plugins -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <!-- Alpine.js Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            cursor: none; /* Hide default cursor */
        }
        
        .cursor-dot {
            width: 12px;
            height: 12px;
            background-color: #78350f; /* Amber-900 */
            border-radius: 50%;
            position: fixed;
            top: 0;
            left: 0;
            transform: translate(-50%, -50%);
            pointer-events: none;
            z-index: 10000;
            transition: transform 0.1s ease-out, background-color 0.2s;
        }

        .cursor-dot.active {
            transform: translate(-50%, -50%) scale(2.5);
            background-color: #f59e0b; /* Amber-500 */
            mix-blend-mode: difference;
        }

        /* Animation Utilities */
         @keyframes fadeInUp {
            from { opacity: 0; transform: translate3d(0, 40px, 0); }
            to { opacity: 1; transform: translate3d(0, 0, 0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }
    </style>
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    @stack('styles')
</head>
<body class="bg-[#fcfbf9] text-[#4a4a4a] dark:bg-stone-950 dark:text-stone-300 antialiased selection:bg-amber-200 selection:text-amber-900 overflow-x-hidden transition-colors duration-300">

    <!-- Custom Cursor Dot Only -->
    <div class="cursor-dot"></div>

    <!-- Navigation -->
    <nav class="fixed w-full z-50 top-0 transition-all duration-300 px-6 py-4 flex justify-between items-center" id="navbar">
        <a href="{{ route('landing') }}" class="text-2xl font-bold tracking-tighter text-amber-900 dark:text-amber-500 hover-target">
            Web<span class="text-amber-600 dark:text-amber-400">Kafe.</span>
        </a>
        
        <div class="flex items-center gap-6">
            <!-- Theme Toggle -->
            <button onclick="toggleTheme()" class="p-2 rounded-full hover:bg-stone-100 dark:hover:bg-stone-800 transition-colors text-amber-900 dark:text-amber-500 hover-target" aria-label="Toggle Theme">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hidden dark:block"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4"/></svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="block dark:hidden"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
            </button>
            
            @auth

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.products.index') }}" class="text-sm font-medium text-amber-900 dark:text-amber-200 hover:text-amber-700 dark:hover:text-amber-400 hover-target">Dashboard</a>
                @endif
                
                <a href="{{ route('orders.index') }}" class="text-sm font-medium text-amber-900 dark:text-amber-200 hover:text-amber-700 dark:hover:text-amber-400 hover-target">My Orders</a>
                
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-amber-900 dark:text-amber-200 hover:text-red-600 dark:hover:text-red-400 transition-colors hover-target">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm font-medium text-amber-900 dark:text-amber-200 hover:text-amber-700 dark:hover:text-amber-400 hover-target">Login</a>
                <a href="{{ route('register') }}" class="hidden md:inline-block px-5 py-2 rounded-full bg-amber-900 text-white dark:bg-amber-700 text-sm font-medium hover:bg-amber-800 dark:hover:bg-amber-600 transition-colors hover-target">
                    Register
                </a>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-stone-900 text-stone-400 py-20">
        <div class="container mx-auto px-6 max-w-7xl grid md:grid-cols-4 gap-12">
            <div class="col-span-1 md:col-span-2">
                <a href="{{ route('landing') }}" class="text-3xl font-bold tracking-tighter text-white mb-6 block">
                    Web<span class="text-amber-500">Kafe.</span>
                </a>
                <p class="max-w-md mb-8">
                    Membangun kultur kopi yang inklusif dan berkualitas. 
                    Hadir untuk menemani setiap momen berhargamu.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-stone-800 flex items-center justify-center hover:bg-amber-600 hover:text-white transition-colors hover-target">IG</a>
                    <a href="#" class="w-10 h-10 rounded-full bg-stone-800 flex items-center justify-center hover:bg-amber-600 hover:text-white transition-colors hover-target">TW</a>
                    <a href="#" class="w-10 h-10 rounded-full bg-stone-800 flex items-center justify-center hover:bg-amber-600 hover:text-white transition-colors hover-target">YT</a>
                </div>
            </div>
            
            <div>
                <h4 class="text-white font-semibold mb-6">Explore</h4>
                <ul class="space-y-4">
                    <li><a href="{{ route('public.cafes.index') }}" class="hover:text-amber-500 transition-colors hover-target">Outlets</a></li>
                    <li><a href="#" class="hover:text-amber-500 transition-colors hover-target">Story</a></li>
                    <li><a href="#" class="hover:text-amber-500 transition-colors hover-target">Careers</a></li>
                </ul>
            </div>

             <div>
                <h4 class="text-white font-semibold mb-6">Contact</h4>
                <ul class="space-y-4">
                    <li>hello@webkafe.com</li>
                    <li>+62 812 3456 7890</li>
                    <li>Jakarta, Indonesia</li>
                </ul>
            </div>
        </div>
        <div class="container mx-auto px-6 max-w-7xl pt-12 mt-12 border-t border-stone-800 text-center text-sm">
            &copy; {{ date('Y') }} WebKafe. All rights reserved.
        </div>
    </footer>

    <script>
        // Shared Logic for Theme and Cursor
        const html = document.documentElement;

        function toggleTheme() {
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                html.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }

        const dot = document.querySelector('.cursor-dot');
        const hoverTargets = document.querySelectorAll('.hover-target');
        
        // Use a simple tracking, or requestAnimationFrame for smoother performance? 
        // Simple is fine for now as per landing page logic.
        document.addEventListener('mousemove', (e) => {
            dot.style.top = `${e.clientY}px`;
            dot.style.left = `${e.clientX}px`;
        });

        // Delegate hover for dynamic content
        document.body.addEventListener('mouseover', (e) => {
            if (e.target.closest('.hover-target')) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
        
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.classList.add('bg-white/80', 'backdrop-blur-md', 'shadow-sm', 'dark:bg-stone-900/80', 'dark:border-b', 'dark:border-stone-800');
            } else {
                nav.classList.remove('bg-white/80', 'backdrop-blur-md', 'shadow-sm', 'dark:bg-stone-900/80', 'dark:border-b', 'dark:border-stone-800');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
