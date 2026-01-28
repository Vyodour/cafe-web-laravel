@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="space-y-4" x-data="orderManager()">
    <!-- Removed Create Order button as per requirements -->
    <!-- <div class="flex justify-end">
        <x-ui.button @click="openCreateModal()">
            Create Order
        </x-ui.button>
    </div> -->

    <x-ui.table>
        <x-slot name="header">
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Order ID</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Customer</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Table</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Items</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Total</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
        </x-slot>

        @forelse($orders as $order)
        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
            <td class="p-4 align-middle font-medium">#{{ $order->id }}</td>
            <td class="p-4 align-middle">{{ $order->user->name ?? 'Guest' }}</td>
            <td class="p-4 align-middle">{{ $order->table->table_number ?? '-' }}</td>
            <td class="p-4 align-middle">{{ $order->orderItems->count() }} Items</td>
            <td class="p-4 align-middle">${{ number_format($order->total_price, 2) }}</td>
            <td class="p-4 align-middle">
                 <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold 
                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 
                       ($order->status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300') }}">
                    {{ ucfirst($order->status) }}
                </span>
            </td>
            <td class="p-4 align-middle">
                <button @click="openShowModal('{{ route('admin.orders.show', $order) }}')" class="text-sm font-medium text-blue-600 hover:text-blue-500 hover:underline">Manage</button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="p-4 text-center text-muted-foreground">No orders found.</td>
        </tr>
        @endforelse
    </x-ui.table>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>

    <!-- Order Details Modal -->
    <x-ui.modal name="order-modal" :show="false" title="Order Details" maxWidth="2xl">
        <div id="modal-content" class="min-h-[100px] flex items-center justify-center">
            <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
        </div>
    </x-ui.modal>

</div>

<script>
    function orderManager() {
        return {
            openShowModal(url) {
                // Determine separator for query params
                const separator = url.includes('?') ? '&' : '?';
                this.loadModalContent(url + separator + 'ajax=1');
            },

            loadModalContent(url) {
                this.$dispatch('open-modal', 'order-modal');
                const contentDiv = document.getElementById('modal-content');
                
                contentDiv.innerHTML = '<div class="flex justify-center p-8"><svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg></div>';

                fetch(url, {
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
            }
        }
    }
</script>
@endsection
