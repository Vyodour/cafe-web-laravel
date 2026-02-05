<div class="relative w-full overflow-auto rounded-lg border border-stone-200 dark:border-stone-800 shadow-sm">
    <table class="w-full caption-bottom text-sm text-left">
        @if (isset($header))
            <thead class="[&_tr]:border-b bg-stone-50 dark:bg-stone-900/50">
                <tr class="border-b border-stone-200 dark:border-stone-800 transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                    {{ $header }}
                </tr>
            </thead>
        @endif
        <tbody class="[&_tr:last-child]:border-0 bg-white dark:bg-stone-950">
            {{ $slot }}
        </tbody>
    </table>
</div>
