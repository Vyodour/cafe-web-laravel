@extends('layouts.public')

@section('title', 'Our Locations')

@section('content')
<div class="pt-32 pb-20 px-6 min-h-screen">
    <div class="container mx-auto max-w-7xl">
        <div class="text-center mb-16 animate-fade-in-up">
            <h1 class="text-5xl md:text-6xl font-bold text-amber-950 dark:text-amber-50 mb-6">Our Outlets</h1>
            <p class="text-xl text-stone-600 dark:text-stone-400 max-w-2xl mx-auto">
                Explore our unique spaces, designed for comfort, productivity, and the perfect cup of coffee.
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($cafes as $cafe)
            <a href="{{ route('public.cafes.show', $cafe->slug) }}" class="group block hover-target">
                <div class="bg-white dark:bg-stone-900 rounded-3xl overflow-hidden border border-stone-100 dark:border-stone-800 shadow-sm group-hover:shadow-xl group-hover:-translate-y-2 transition-all duration-300">
                    <div class="aspect-[4/3] overflow-hidden relative">
                        <img src="{{ $cafe->image_url }}" alt="{{ $cafe->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition-colors"></div>
                        <div class="absolute bottom-4 right-4 bg-white/95 dark:bg-stone-900/95 backdrop-blur px-4 py-2 rounded-full text-sm font-bold text-amber-900 dark:text-amber-500 shadow-lg">
                            Visit Menu &rarr;
                        </div>
                    </div>
                    <div class="p-8">
                        <h2 class="text-2xl font-bold text-amber-950 dark:text-white mb-2">{{ $cafe->name }}</h2>
                        <p class="text-stone-500 dark:text-stone-400 mb-6 line-clamp-2">{{ $cafe->description }}</p>
                        
                        <div class="flex items-center gap-4 text-sm font-medium text-stone-600 dark:text-stone-300 border-t border-stone-100 dark:border-stone-800 pt-4">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $cafe->city ?? 'Location' }}
                            </span>
                            <span class="w-1 h-1 rounded-full bg-stone-300"></span>
                            <span>{{ $cafe->products->count() }} Items</span>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
