@props([
    'variant' => 'primary',
    'size' => 'default',
    'type' => 'button'
])

@php
    $baseClass = "inline-flex items-center justify-center rounded-md font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50";
    
    $variants = [
        'primary' => 'bg-amber-600 text-white shadow hover:bg-amber-700 dark:bg-amber-600 dark:hover:bg-amber-500',
        'secondary' => 'bg-secondary text-secondary-foreground shadow-sm hover:bg-secondary/80',
        'destructive' => 'bg-red-500 text-white shadow-sm hover:bg-red-600 dark:bg-red-900 dark:text-red-100 dark:hover:bg-red-800',
        'outline' => 'border border-input bg-transparent shadow-sm hover:bg-accent hover:text-accent-foreground',
        'ghost' => 'hover:bg-accent hover:text-accent-foreground',
        'link' => 'text-primary underline-offset-4 hover:underline',
    ];

    $sizes = [
        'default' => 'h-9 px-4 py-2 text-sm',
        'sm' => 'h-8 rounded-md px-3 text-xs',
        'lg' => 'h-10 rounded-md px-8',
        'icon' => 'h-9 w-9',
    ];

    $classes = "$baseClass " . ($variants[$variant] ?? $variants['primary']) . " " . ($sizes[$size] ?? $sizes['default']);
@endphp

<button {{ $attributes->merge(['type' => $type, 'class' => $classes]) }}>
    {{ $slot }}
</button>
