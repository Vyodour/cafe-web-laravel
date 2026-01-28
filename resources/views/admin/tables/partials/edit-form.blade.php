<div class="max-w-md mx-auto">
    <x-ui.card>
        <x-slot name="header">
            <h2 class="text-lg font-semibold">Edit Table</h2>
            <p class="text-sm text-muted-foreground">Update details for Table {{ $table->table_number }}.</p>
        </x-slot>

        <form action="{{ route('admin.tables.update', $table) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div class="grid gap-2">
                    <x-ui.label for="number" value="Table Number" />
                    <x-ui.input id="number" type="number" name="number" 
                        value="{{ old('number', $table->table_number) }}" required autofocus />
                </div>

                <div class="grid gap-2">
                    <x-ui.label for="capacity" value="Capacity (Seats)" />
                    <!-- Note: Capacity is technically not in DB migration as per discussion, but kept in form for potentially future use or as metadata if column exists -->
                    <x-ui.input id="capacity" type="number" name="capacity" 
                        value="{{ old('capacity', $table->capacity ?? 4) }}" required min="1" />
                </div>

                <div class="grid gap-2">
                     <x-ui.label for="status" value="Status" />
                     <select id="status" name="status" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                        <option value="active" {{ $table->status == 'available' ? 'selected' : '' }}>Active (Available)</option>
                        <option value="inactive" {{ $table->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="occupied" {{ $table->status == 'occupied' ? 'selected' : '' }}>Occupied</option>
                     </select>
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-6">
                 @if(!request()->ajax() && !request('ajax'))
                <a href="{{ route('admin.tables.index') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2">
                    Cancel
                </a>
                @endif
                <x-ui.button type="submit">Update Table</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</div>
