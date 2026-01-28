@php
    // Ensure we have access to order status classes helper or define logic here
@endphp
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Order #{{ $order->id }}</h2>
    @if(!request()->ajax() && !request('ajax'))
    <a href="{{ route('admin.orders.index') }}" class="text-blue-500 hover:text-blue-800">Back to List</a>
    @endif
</div>

<div class="bg-card text-card-foreground shadow-md rounded-lg overflow-hidden border border-border">
    <div class="px-6 py-4 border-b border-border bg-muted/50">
        <div class="flex justify-between items-center">
            <div>
                 <p class="font-semibold">Table: {{ $order->table->table_number ?? 'N/A' }}</p>
                 <p class="text-sm text-muted-foreground">{{ $order->created_at->format('M d, Y H:i') }}</p>
            </div>
            <div>
                 <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold 
                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 
                       ($order->status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300') }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        <h3 class="font-semibold mb-3">Order Items</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-muted text-muted-foreground uppercase">
                    <tr>
                        <th class="px-4 py-2">Item</th>
                        <th class="px-4 py-2 text-center">Qty</th>
                        <th class="px-4 py-2 text-right">Price</th>
                        <th class="px-4 py-2 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td class="px-4 py-2">{{ $item->product->name }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->quantity }}</td>
                        <td class="px-4 py-2 text-right">${{ number_format($item->unit_price, 2) }}</td>
                        <td class="px-4 py-2 text-right">${{ number_format($item->unit_price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                    <tr class="font-bold bg-muted/30">
                        <td colspan="3" class="px-4 py-3 text-right">Total:</td>
                        <td class="px-4 py-3 text-right">${{ number_format($order->total_price, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-6 border-t border-border pt-6">
            <h3 class="font-semibold mb-3">Update Status</h3>
            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="flex gap-4 items-end">
                @csrf
                @method('PUT')
                
                <div class="flex-1">
                    <x-ui.label for="status" value="Status" />
                    <select id="status" name="status" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                
                <x-ui.button type="submit">Update</x-ui.button>
            </form>
        </div>
    </div>
</div>
