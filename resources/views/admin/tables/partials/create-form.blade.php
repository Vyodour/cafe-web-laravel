<div class="max-w-md mx-auto">
    <x-ui.card>
        <x-slot name="header">
            <h2 class="text-lg font-semibold">Create New Table</h2>
            <p class="text-sm text-muted-foreground">Add a new table to the floor plan.</p>
        </x-slot>

        <form action="{{ route('admin.tables.store') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <div class="grid gap-2">
                    <x-ui.label for="table_number" value="Table Number" />
                    <x-ui.input id="table_number" type="number" name="table_number" :value="old('table_number')" required autofocus />
                </div>

                <div class="grid gap-2">
                     <x-ui.label for="status" value="Status" />
                     <select id="status" name="status" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                        <option value="active">Active (Available)</option>
                        <option value="inactive">Inactive</option>
                        <option value="occupied">Occupied</option>
                     </select>
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-6">
                 @if(!request()->ajax() && !request('ajax'))
                <a href="{{ route('admin.tables.index') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2">
                    Cancel
                </a>
                @endif
                <x-ui.button type="submit">Create Table</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</div>
