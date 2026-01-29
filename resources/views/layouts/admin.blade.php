<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Kafe Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Google Fonts (Inter) -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
    
    <script>
        // Check for saved theme
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="h-full bg-background text-foreground antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-sidebar text-sidebar-foreground border-r border-sidebar-border transition-transform transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               @click.away="sidebarOpen = false">
            
            <div class="flex items-center justify-center h-16 border-b border-sidebar-border">
                <span class="text-2xl font-bold text-sidebar-primary animate-enter">Kafe Admin</span>
            </div>

            <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto animate-enter-delay-1">
                <x-admin.sidebar-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')" icon="box">
                    Products
                </x-admin.sidebar-link>
                
                <x-admin.sidebar-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')" icon="tag">
                    Categories
                </x-admin.sidebar-link>

                <x-admin.sidebar-link :href="route('admin.tables.index')" :active="request()->routeIs('admin.tables.*')" icon="grid">
                    Tables
                </x-admin.sidebar-link>

                <x-admin.sidebar-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')" icon="shopping-cart">
                    Orders
                </x-admin.sidebar-link>

                <x-admin.sidebar-link :href="route('admin.transactions.index')" :active="request()->routeIs('admin.transactions.*')" icon="credit-card">
                    Transactions
                </x-admin.sidebar-link>
                
                <!-- Divider -->
                <div class="my-4 border-t border-sidebar-border"></div>

                <x-admin.sidebar-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')" icon="settings">
                    Settings
                </x-admin.sidebar-link>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 text-sm font-medium rounded-lg text-sidebar-foreground hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/20 dark:hover:text-red-400 transition-colors group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Logout
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex flex-col flex-1 h-full overflow-hidden transition-all duration-300">
            
            <!-- Topbar -->
            <header class="flex items-center justify-between px-6 py-4 bg-background border-b border-border animate-enter">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-muted-foreground focus:outline-none lg:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <h2 class="ml-4 text-xl font-semibold text-foreground lg:ml-0 transition-opacity duration-300">
                        @yield('title')
                    </h2>
                </div>

                <div class="flex items-center space-x-4">
                     <!-- User Dropdown (Simple for now) -->
                     <span class="text-sm font-medium text-muted-foreground">{{ auth()->user()->name ?? 'Admin' }}</span>
                </div>
            </header>

            <!-- Main Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-muted/20 p-6">
                <!-- Session Alerts with Animation -->
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 transform translate-y-0"
                         x-transition:leave-end="opacity-0 transform -translate-y-2"
                         class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-800">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if ($errors->any())
                     <div x-data="{ show: true }" x-show="show"
                          class="mb-4 p-4 rounded bg-red-100 text-red-800 border border-red-200 dark:bg-red-900/30 dark:text-red-300 dark:border-red-800 animate-pulse">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="animate-enter-delay-2">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

</body>
</html>
