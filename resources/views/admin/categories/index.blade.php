@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
<div class="space-y-4" x-data="categoryManager()">
    <div class="flex justify-end">
        <x-ui.button @click="openCreateModal()">
            Add Category
        </x-ui.button>
    </div>

    <x-ui.table>
        <x-slot name="header">
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">ID</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Name</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Slug</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Description</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
        </x-slot>

        @forelse($categories as $category)
        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
            <td class="p-4 align-middle">{{ $category->id }}</td>
            <td class="p-4 align-middle font-medium">{{ $category->name }}</td>
            <td class="p-4 align-middle">{{ $category->slug }}</td>
            <td class="p-4 align-middle">{{ Str::limit($category->description, 50) }}</td>
            <td class="p-4 align-middle">
                <div class="flex items-center gap-2">
                    <button @click="openEditModal('{{ route('admin.categories.edit', $category) }}')" class="text-sm font-medium text-blue-600 hover:text-blue-500 hover:underline">Edit</button>
                    <button @click="confirmDelete('{{ route('admin.categories.destroy', $category) }}', '{{ addslashes($category->name) }}')" class="text-sm font-medium text-destructive hover:text-destructive/80 hover:underline">Delete</button>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="p-4 text-center text-muted-foreground">No categories found.</td>
        </tr>
        @endforelse
    </x-ui.table>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>

    <!-- Create/Edit Modal -->
    <x-ui.modal name="category-modal" :show="false" title="Category Details">
        <div id="modal-content" class="min-h-[100px] flex items-center justify-center">
            <!-- Content will be loaded here via AJAX -->
            <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
        </div>
    </x-ui.modal>

    <!-- Delete Confirmation Modal -->
     <x-ui.modal name="delete-modal" :show="false" title="Delete Category" maxWidth="md">
        <div class="space-y-4">
            <p>Are you sure you want to delete category <span class="font-bold" x-text="deleteName"></span>?</p>
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
    function categoryManager() {
        return {
            deleteUrl: '',
            deleteName: '',

            openCreateModal() {
                this.loadModalContent('{{ route('admin.categories.create') }}', 'Create Category');
            },

            openEditModal(url) {
                this.loadModalContent(url, 'Edit Category');
            },

            loadModalContent(url, title) {
                this.$dispatch('open-modal', 'category-modal');
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
