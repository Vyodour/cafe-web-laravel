<div class="max-w-2xl mx-auto space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
             @if($product->image)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-auto rounded-lg shadow-md object-cover">
            @else
                <div class="w-full h-64 bg-muted flex items-center justify-center rounded-lg shadow-md text-muted-foreground">
                    No Image Available
                </div>
            @endif
        </div>
        
        <div class="space-y-4">
            <div>
                <h3 class="text-2xl font-bold">{{ $product->name }}</h3>
                <p class="text-lg font-semibold text-primary">${{ number_format($product->price, 2) }}</p>
                <span class="inline-flex mt-2 items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $product->is_available ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                    {{ $product->is_available ? 'Available' : 'Unavailable' }}
                </span>
            </div>

            <div>
                <h4 class="font-semibold text-sm text-muted-foreground">Category</h4>
                <p>{{ $product->category->name ?? 'Uncategorized' }}</p>
            </div>

            <div>
                <h4 class="font-semibold text-sm text-muted-foreground">Description</h4>
                <p class="text-gray-600 dark:text-gray-300">{{ $product->description ?? 'No description provided.' }}</p>
            </div>
            
             <div>
                <h4 class="font-semibold text-sm text-muted-foreground">Stock</h4>
                <p>{{ $product->stock_quantity ?? 0 }} units</p>
            </div>
        </div>
    </div>

    @if(!request()->ajax() && !request('ajax'))
    <div class="flex justify-end pt-6 border-t border-border">
         <a href="{{ route('admin.products.index') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2">
            Back to List
        </a>
    </div>
    @endif
</div>
