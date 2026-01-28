@extends('layouts.admin')

@section('title', 'Tables')

@section('content')
<div class="space-y-4" x-data="tableManager()">
    <div class="flex justify-end">
        <x-ui.button @click="openCreateModal()">
            Add Table
        </x-ui.button>
    </div>

    <x-ui.table>
        <x-slot name="header">
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">ID</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Number</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">QR Token</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
        </x-slot>

        @forelse($tables as $table)
        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
            <td class="p-4 align-middle">{{ $table->id }}</td>
            <td class="p-4 align-middle font-medium">Table {{ $table->table_number }}</td>
            <td class="p-4 align-middle">
                <code class="relative rounded bg-muted px-[0.3rem] py-[0.2rem] font-mono text-sm font-semibold">
                    {{ Str::limit($table->qr_code_token, 10) }}
                </code>
            </td>
            <td class="p-4 align-middle">
                 <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold 
                    {{ $table->status === 'available' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 
                       ($table->status === 'occupied' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300') }}">
                    {{ ucfirst($table->status) }}
                </span>
            </td>
            <td class="p-4 align-middle">
                <div class="flex items-center gap-2">
                    <button @click="openEditModal('{{ route('admin.tables.edit', $table) }}')" class="text-sm font-medium text-blue-600 hover:text-blue-500 hover:underline">Edit</button>
                    <button @click="confirmDelete('{{ route('admin.tables.destroy', $table) }}', 'Table {{ $table->table_number }}')" class="text-sm font-medium text-destructive hover:text-destructive/80 hover:underline">Delete</button>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="p-4 text-center text-muted-foreground">No tables found.</td>
        </tr>
        @endforelse
    </x-ui.table>

    <div class="mt-4">
        {{ $tables->links() }}
    </div>

    <!-- Create/Edit Modal -->
    <x-ui.modal name="table-modal" :show="false" title="Table Details">
        <div id="modal-content" class="min-h-[100px] flex items-center justify-center">
            <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
        </div>
    </x-ui.modal>

    <!-- Delete Confirmation Modal -->
     <x-ui.modal name="delete-modal" :show="false" title="Delete Table" maxWidth="md">
        <div class="space-y-4">
            <p>Are you sure you want to delete <span class="font-bold" x-text="deleteName"></span>?</p>
            <p class="text-sm text-muted-foreground">This action cannot be undone.</p>
            
            <div class="flex justify-end gap-4">
                <button @click="$dispatch('close-modal', 'delete-modal')" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2">
                    Cancel
                </button>
                <form :action="deleteUrl" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <x-ui.button variant="destructive" type="submit">Delete</x-ui.button>
                </form>
            </div>
        </div>
    </x-ui.modal>

</div>

<script>
    function tableManager() {
        return {
            deleteUrl: '',
            deleteName: '',

            openCreateModal() {
                this.loadModalContent('{{ route('admin.tables.create') }}', 'Create Table');
            },

            openEditModal(url) {
                this.loadModalContent(url, 'Edit Table');
            },

            loadModalContent(url, title) {
                this.$dispatch('open-modal', 'table-modal');
                const contentDiv = document.getElementById('modal-content');
                
                contentDiv.innerHTML = '<div class="flex justify-center p-8"><svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg></div>';

                const separator = url.includes('?') ? '&' : '?';
                fetch(url + separator + 'ajax=1', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    contentDiv.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error loading modal content:', error);
                    contentDiv.innerHTML = '<p class="text-red-500 text-center">Error loading content.</p>';
                });
            },

            confirmDelete(url, name) {
                this.deleteUrl = url;
                this.deleteName = name;
                this.$dispatch('open-modal', 'delete-modal');
            }
        }
    }
</script>
@endsection
