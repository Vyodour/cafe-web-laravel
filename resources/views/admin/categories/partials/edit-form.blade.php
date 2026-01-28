<div class="max-w-md mx-auto">
    <x-ui.card>
        <x-slot name="header">
            <h2 class="text-lg font-semibold">Edit Category</h2>
            <p class="text-sm text-muted-foreground">Update {{ $category->name }} details.</p>
        </x-slot>

        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div class="grid gap-2">
                    <x-ui.label for="name" value="Category Name" />
                    <x-ui.input autocomplete="off" id="name" type="text" name="name" 
                        value="{{ old('name', $category->name) }}" required autofocus />
                </div>

                <div class="grid gap-2">
                    <x-ui.label for="description" value="Description (Optional)" />
                    <x-ui.textarea autocomplete="off" id="description" name="description">{{ old('description', $category->description) }}</x-ui.textarea>
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-6">
                 @if(!request()->ajax() && !request('ajax'))
                 <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2">
                    Cancel
                </a>
                @endif
                <x-ui.button type="submit">Update Category</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</div>
