<div class="max-w-md mx-auto">
    <x-ui.card>
        <x-slot name="header">
            <h2 class="text-lg font-semibold">New Transaction</h2>
            <p class="text-sm text-muted-foreground">Record a manual payment for an order.</p>
        </x-slot>

        <form action="{{ route('admin.transactions.store') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <div class="grid gap-2">
                     <x-ui.label for="order_id" value="Order" />
                     <select id="order_id" name="order_id" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                        <option value="">Select Order</option>
                        @foreach($orders as $order)
                            <option value="{{ $order->id }}">Order #{{ $order->id }} - {{ $order->table->table_number ?? 'N/A' }} (${{ number_format($order->total_price, 2) }})</option>
                        @endforeach
                     </select>
                </div>

                <div class="grid gap-2">
                    <x-ui.label for="amount" value="Amount Paid ($)" />
                    <x-ui.input id="amount" type="number" step="0.01" name="amount_paid" :value="old('amount_paid')" required />
                </div>

                <div class="grid gap-2">
                     <x-ui.label for="payment_method" value="Payment Method" />
                     <select id="payment_method" name="payment_method" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                        <option value="cash">Cash</option>
                        <option value="card">Card</option>
                        <option value="qris">QRIS</option>
                     </select>
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-6">
                 @if(!request()->ajax() && !request('ajax'))
                <a href="{{ route('admin.transactions.index') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2">
                    Cancel
                </a>
                @endif
                <x-ui.button type="submit">Record Payment</x-ui.button>
            </div>
        </form>
    </x-ui.card>
</div>
