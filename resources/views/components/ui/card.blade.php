<div class="rounded-lg border border-stone-200 bg-white text-stone-950 shadow-sm dark:border-stone-800 dark:bg-stone-950 dark:text-stone-50">
    @if(isset($header))
        <div class="flex flex-col space-y-1.5 p-6">
            {{ $header }}
        </div>
    @endif
    <div class="p-6 pt-0">
        {{ $slot }}
    </div>
    @if(isset($footer))
        <div class="flex items-center p-6 pt-0">
            {{ $footer }}
        </div>
    @endif
</div>
