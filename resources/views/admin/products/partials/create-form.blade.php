<div class="max-w-2xl mx-auto">
    <x-ui.card>
        <x-slot name="header">
            <h2 class="text-lg font-semibold">Create New Product</h2>
            <p class="text-sm text-muted-foreground">Add a new product to your menu.</p>
        </x-slot>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="grid gap-2">
                        <x-ui.label for="name" value="Product Name" />
                        <x-ui.input id="name" type="text" name="name" :value="old('name')" required />
                    </div>
                    <div class="grid gap-2">
                        <x-ui.label for="price" value="Price ($)" />
                        <x-ui.input id="price" type="number" step="0.01" name="price" :value="old('price')" required />
                    </div>
                </div>

                <div class="grid gap-2">
                     <x-ui.label for="category_id" value="Category" />
                     <select id="category_id" name="category_id" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                     </select>
                </div>

                <div class="grid gap-2">
                    <x-ui.label for="description" value="Description" />
                    <x-ui.textarea id="description" name="description">{{ old('description') }}</x-ui.textarea>
                </div>
                
                <div class="grid gap-2">
                    <x-ui.label for="image" value="Product Image" />
                    <x-ui.input id="image" type="file" name="image" class="file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-primary-foreground hover:file:bg-primary/90"/>
                </div>

                <div class="flex items-center space-x-2">
                    <input type="hidden" name="is_available" value="0">
                     <input type="checkbox" id="is_available" name="is_available" value="1" class="h-4 w-4 rounded border-primary text-primary focus:ring-primary" checked>
                    <x-ui.label for="is_available" value="Available for order" />
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-6">
                @if(!request()->ajax() && !request('ajax'))
                <a href="{{ route('admin.products.index') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2">
                    Cancel
                </a>
                @endif
                <x-ui.button type="submit">Create Product</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</div>
