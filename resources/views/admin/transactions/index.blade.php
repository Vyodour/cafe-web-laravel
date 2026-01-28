@extends('layouts.admin')

@section('title', 'Transactions')

@section('content')
<div class="space-y-4" x-data="transactionManager()">
    <div class="flex justify-end">
        <x-ui.button @click="openCreateModal()">
            Record Transaction
        </x-ui.button>
    </div>

    <x-ui.table>
        <x-slot name="header">
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">ID</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Order ID</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Method</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Amount</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Status</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Date</th>
            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Actions</th>
        </x-slot>

        @forelse($transactions as $transaction)
        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
            <td class="p-4 align-middle font-medium">#{{ $transaction->id }}</td>
            <td class="p-4 align-middle">
                <a href="{{ route('admin.orders.show', $transaction->order_id ?? 0) }}" class="text-blue-600 hover:underline">
                    #{{ $transaction->order_id }}
                </a>
            </td>
            <td class="p-4 align-middle">{{ ucfirst($transaction->payment_method) }}</td>
            <td class="p-4 align-middle">${{ number_format($transaction->gross_amount, 2) }}</td>
            <td class="p-4 align-middle">
                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold 
                    {{ $transaction->payment_status === 'settlement' || $transaction->payment_status === 'paid' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 
                       ($transaction->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300') }}">
                    {{ ucfirst($transaction->payment_status) }}
                </span>
            </td>
             <td class="p-4 align-middle text-muted-foreground">{{ $transaction->created_at->format('M d, Y H:i') }}</td>
            <td class="p-4 align-middle">
                <a href="{{ route('admin.transactions.show', $transaction) }}" class="text-sm font-medium text-muted-foreground hover:text-foreground hover:underline">View</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="p-4 text-center text-muted-foreground">No transactions found.</td>
        </tr>
        @endforelse
    </x-ui.table>

    <div class="mt-4">
        {{ $transactions->links() }}
    </div>

    <!-- Create Modal -->
    <x-ui.modal name="transaction-modal" :show="false" title="Record Transaction">
        <div id="modal-content" class="min-h-[100px] flex items-center justify-center">
            <svg class="animate-spin h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
        </div>
    </x-ui.modal>

</div>

<script>
    function transactionManager() {
        return {
            openCreateModal() {
                this.loadModalContent('{{ route('admin.transactions.create') }}');
            },

            loadModalContent(url) {
                this.$dispatch('open-modal', 'transaction-modal');
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
            }
        }
    }

    // Global script for Transaction Create form
    window.updateAmount = function(select) {
        const amountInput = document.getElementById('amount_paid');
        if (select.selectedIndex > 0) {
            const amount = select.options[select.selectedIndex].dataset.amount;
            amountInput.value = amount;
        } else {
            amountInput.value = '';
        }
    }
</script>
@endsection
