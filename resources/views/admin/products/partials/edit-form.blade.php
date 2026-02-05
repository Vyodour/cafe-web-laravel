<div class="max-w-2xl mx-auto">
    <x-ui.card>
        <x-slot name="header">
            <h2 class="text-lg font-semibold">Edit Product</h2>
            <p class="text-sm text-muted-foreground">Update {{ $product->name }} details.</p>
        </x-slot>

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="grid gap-2">
                        <x-ui.label for="name" value="Product Name" />
                        <x-ui.input id="name" type="text" name="name" value="{{ $product->name }}" required />
                    </div>
                    <div class="grid gap-2">
                        <x-ui.label for="price" value="Price ($)" />
                        <x-ui.input id="price" type="number" step="0.01" name="price" value="{{ $product->price }}" required />
                    </div>
                </div>

                <div class="grid gap-2">
                     <x-ui.label for="category_id" value="Category" />
                     <select id="category_id" name="category_id" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                     </select>
                </div>

                <div class="grid gap-2">
                    <x-ui.label for="description" value="Description" />
                    <x-ui.textarea id="description" name="description">{{ $product->description }}</x-ui.textarea>
                </div>
                
                <div class="grid gap-2">
                    <x-ui.label for="image" value="Product Image" />
                    
                    <!-- Hidden input to signal image deletion -->
                    <input type="hidden" id="delete_image" name="delete_image" value="0">

                    <!-- Image Preview Container -->
                    <div id="image-preview-container" class="relative {{ $product->image ? 'block' : 'hidden' }} mb-4 w-max group">
                         <!-- Removed JS from here, using global function -->
                        <img id="image-preview" src="{{ $product->image ? $product->image_url : '' }}" alt="Product Preview" class="h-48 w-48 rounded-lg object-cover border-2 border-border shadow-sm">
                        
                        <!-- Delete Button (X) -->
                        <button type="button" onclick="window.removeImage()" class="absolute -top-3 -right-3 h-8 w-8 bg-destructive text-destructive-foreground rounded-full hover:bg-destructive/90 transition-all shadow-md flex items-center justify-center ring-2 ring-background focus:outline-none focus:ring-ring">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>

                    <x-ui.input id="image" type="file" name="image" class="file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-primary-foreground hover:file:bg-primary/90" onchange="window.previewImage(event)"/>
                </div>

                <div class="flex items-center space-x-2 pt-2">
                    <input type="hidden" name="is_available" value="0">
                    <x-ui.toggle name="is_available" id="is_available" :checked="$product->is_available" label="Available for order" />
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-6">
                 @if(!request()->ajax() && !request('ajax'))
                 <a href="{{ route('admin.products.index') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2">
                    Cancel
                </a>
                @endif
                <x-ui.button type="submit">Update Product</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</div>
