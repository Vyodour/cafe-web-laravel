@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-card text-card-foreground shadow rounded-lg p-6 border border-border">
        <h3 class="text-lg font-medium leading-6 mb-4">Appearance</h3>
        
        <div class="flex items-center justify-between">
            <div>
                <p class="font-medium">Dark Mode</p>
                <p class="text-sm text-muted-foreground">Enable dark mode for the dashboard.</p>
            </div>
            
            <!-- Toggle Switch -->
            <button x-data="{ 
                        darkMode: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
                        toggle() {
                            this.darkMode = !this.darkMode;
                            if (this.darkMode) {
                                document.documentElement.classList.add('dark');
                                localStorage.theme = 'dark';
                            } else {
                                document.documentElement.classList.remove('dark');
                                localStorage.theme = 'light';
                            }
                        }
                    }"
                    @click="toggle()"
                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"
                    :class="darkMode ? 'bg-primary' : 'bg-input'"
                    role="switch" 
                    aria-checked="false">
                <span aria-hidden="true" 
                      class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                      :class="darkMode ? 'translate-x-5' : 'translate-x-0'">
                </span>
            </button>
        </div>
    </div>
</div>
@endsection
