@extends('layouts.admin')

@section('title', 'Products')

@section('content')
<div class="space-y-4" x-data="productManager()">
    <div class="flex justify-end">
        <x-ui.button @click="openCreateModal()">
            Add Product
        </x-ui.button>
    </div>

    <x-ui.table>
        <x-slot name="header">
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Image</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Name</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Category</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Price</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Stock</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
        </x-slot>

        @forelse($products as $product)
        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
            <td class="p-4 align-middle">
                @if($product->image)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-10 w-10 rounded-md object-cover cursor-pointer hover:scale-110 transition-transform" @click="viewImage('{{ $product->image_url }}')">
                @else
                    <span class="flex h-10 w-10 items-center justify-center rounded-md bg-muted text-xs text-muted-foreground">No Img</span>
                @endif
            </td>
            <td class="p-4 align-middle font-medium">{{ $product->name }}</td>
            <td class="p-4 align-middle">{{ $product->category->name ?? '-' }}</td>
            <td class="p-4 align-middle">${{ number_format($product->price, 2) }}</td>
            <td class="p-4 align-middle">{{ $product->stock_quantity }}</td>
            <td class="p-4 align-middle">
                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $product->is_available ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                    {{ $product->is_available ? 'Active' : 'Inactive' }}
                </span>
            </td>
            <td class="p-4 align-middle">
                <div class="flex items-center gap-2">
                    <button @click="openShowModal('{{ route('admin.products.show', $product) }}')" class="text-sm font-medium text-muted-foreground hover:text-foreground hover:underline">View</button>
                    <button @click="openEditModal('{{ route('admin.products.edit', $product) }}')" class="text-sm font-medium text-blue-600 hover:text-blue-500 hover:underline">Edit</button>
                    <button @click="confirmDelete('{{ route('admin.products.destroy', $product) }}', '{{ addslashes($product->name) }}')" class="text-sm font-medium text-destructive hover:text-destructive/80 hover:underline">Delete</button>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="p-4 text-center text-muted-foreground">No products found.</td>
        </tr>
        @endforelse
    </x-ui.table>

    <div class="mt-4">
        {{ $products->links() }}
    </div>

    <!-- Create/Edit/Show Modal -->
    <x-ui.modal name="product-modal" :show="false" title="Product Details">
        <div id="modal-content" class="min-h-[100px] flex items-center justify-center">
            <!-- Content will be loaded here via AJAX -->
             <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
        </div>
    </x-ui.modal>

    <!-- Delete Confirmation Modal -->
     <x-ui.modal name="delete-modal" :show="false" title="Delete Product" maxWidth="md">
        <div class="space-y-4">
            <p>Are you sure you want to delete product <span class="font-bold" x-text="deleteName"></span>?</p>
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

    <!-- Image View Modal -->
    <x-ui.modal name="image-modal" :show="false" title="Product Image" maxWidth="lg">
        <div class="flex justify-center">
            <img :src="imageUrl" alt="Product Image" class="max-h-[80vh] w-auto rounded-md">
        </div>
    </x-ui.modal>

</div>

<script>
    function productManager() {
        return {
            deleteUrl: '',
            deleteName: '',
            imageUrl: '',

            openCreateModal() {
                this.loadModalContent('{{ route('admin.products.create') }}', 'Create Product');
            },

            openEditModal(url) {
                this.loadModalContent(url, 'Edit Product');
            },

            openShowModal(url) {
                this.loadModalContent(url, 'Product Details');
            },

            viewImage(url) {
                this.imageUrl = url;
                this.$dispatch('open-modal', 'image-modal');
            },

            loadModalContent(url, title) {
                this.$dispatch('open-modal', 'product-modal');
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

    // Global Image Logic for Modals
    window.previewImage = function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('image-preview');
        const container = document.getElementById('image-preview-container');
        const deleteInput = document.getElementById('delete_image');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('hidden');
                deleteInput.value = '0'; 
            }
            reader.readAsDataURL(file);
        }
    }

    window.removeImage = function() {
        const preview = document.getElementById('image-preview');
        const container = document.getElementById('image-preview-container');
        const fileInput = document.getElementById('image');
        const deleteInput = document.getElementById('delete_image');

        preview.src = '';
        container.classList.add('hidden');
        fileInput.value = '';
        deleteInput.value = '1'; 
    }
</script>
@endsection
