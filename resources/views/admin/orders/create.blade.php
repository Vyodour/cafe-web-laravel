@if(!request()->ajax())
@extends('layouts.admin')
@section('title', 'Create Order')
@section('content')
@endif

<div class="{{ request()->ajax() ? '' : 'max-w-4xl mx-auto' }}">
    <form action="{{ route('admin.orders.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Left Column: Order Details -->
            <div class="md:col-span-2 space-y-6">
                <x-ui.card>
                    @if(!request()->ajax())
                    <x-slot name="header">
                        <h2 class="text-lg font-semibold">Order Items</h2>
                        <p class="text-sm text-muted-foreground">Select products to add to the order.</p>
                    </x-slot>
                    @endif

                    <div id="order-items" class="space-y-4">
                        <!-- Initial Item Row -->
                        <div class="order-item grid grid-cols-12 gap-2 items-end">
                             <div class="col-span-7">
                                <x-ui.label value="Product" class="mb-2 block"/>
                                <select name="items[0][product_id]" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" required onchange="window.updatePrice(this)">
                                    <option value="">Select Product...</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                            {{ $product->name }} (${{ number_format($product->price, 2) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-3">
                                <x-ui.label value="Qty" class="mb-2 block"/>
                                <x-ui.input type="number" name="items[0][quantity]" value="1" min="1" required onchange="window.updateTotal()" />
                            </div>
                            <div class="col-span-2">
                                <x-ui.button type="button" variant="destructive" size="icon" onclick="window.removeItem(this)" class="w-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hidden Template Row for JS Cloning -->
                    <div id="order-item-template" class="order-item grid grid-cols-12 gap-2 items-end mt-4 hidden">
                         <div class="col-span-7">
                            <select name="items[0][product_id]" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" required onchange="window.updatePrice(this)">
                                <option value="">Select Product...</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                        {{ $product->name }} (${{ number_format($product->price, 2) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-3">
                            <input type="number" name="items[0][quantity]" value="1" min="1" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" required onchange="window.updateTotal()" />
                        </div>
                        <div class="col-span-2">
                            <button type="button" onclick="window.removeItem(this)" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 bg-destructive text-destructive-foreground hover:bg-destructive/90 h-10 w-10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div class="mt-4">
                         <x-ui.button type="button" variant="outline" onclick="window.addItem()" class="w-full">
                            + Add Another Item
                        </x-ui.button>
                    </div>
                </x-ui.card>
            </div>

            <!-- Right Column: Summary -->
            <div class="space-y-6">
                <x-ui.card>
                    @if(!request()->ajax())
                    <x-slot name="header">
                        <h2 class="text-lg font-semibold">Order Summary</h2>
                    </x-slot>
                    @endif

                    <div class="space-y-4">
                        <div class="grid gap-2">
                            <x-ui.label for="table_id" value="Select Table" />
                            <select id="table_id" name="table_id" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" required>
                                <option value="">Choose Table...</option>
                                @foreach($tables as $table)
                                    <option value="{{ $table->id }}">Table {{ $table->table_number }} ({{ ucfirst($table->status) }})</option>
                                @endforeach
                            </select>
                        </div>

                         <div class="pt-4 border-t border-border">
                            <div class="flex justify-between items-center text-lg font-bold">
                                <span>Total:</span>
                                <span id="grand-total">$0.00</span>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex flex-col gap-3">
                             <x-ui.button type="submit" class="w-full">Place Order</x-ui.button>
                             @if(!request()->ajax())
                             <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 px-4 py-2">
                                Cancel
                            </a>
                            @endif
                        </div>
                    </div>
                </x-ui.card>
            </div>
        </div>
    </form>
</div>

@if(!request()->ajax())
@endsection
@endif
