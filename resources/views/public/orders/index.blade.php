@extends('layouts.public')

@section('content')
<section class="min-h-screen pt-32 pb-20 bg-[#fcfbf9] dark:bg-stone-950">
    <div class="container mx-auto px-6 max-w-4xl">
        <h1 class="text-3xl font-bold text-amber-900 dark:text-amber-500 mb-8">My Orders</h1>

        @if(session('success'))
            <div class="p-4 mb-4 text-green-800 bg-green-100 rounded-lg dark:bg-green-900 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 mb-4 text-red-800 bg-red-100 rounded-lg dark:bg-red-900 dark:text-red-300">
                {{ session('error') }}
            </div>
        @endif

        <div class="space-y-6">
            @forelse ($orders as $order)
                <div class="bg-white dark:bg-stone-900 rounded-xl shadow-sm p-6 border border-stone-200 dark:border-stone-800">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 gap-4">
                        <div>
                            <span class="text-xs text-stone-500 uppercase tracking-wider">Order ID</span>
                            <h3 class="font-bold text-lg text-stone-800 dark:text-stone-200">#{{ $order->id }}</h3>
                            <span class="text-xs text-stone-400">{{ $order->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($order->status == 'processing' || $order->status == 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                @elseif($order->status == 'cancelled') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300 @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                            
                            @if($order->status == 'pending')
                                <form action="{{ route('orders.check', $order) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs rounded-lg transition-colors">
                                        Check Status
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="border-t border-stone-100 dark:border-stone-800 pt-4">
                        @foreach ($order->orderItems as $item)
                        <div class="flex justify-between items-center mb-2 text-sm">
                            <span class="text-stone-600 dark:text-stone-400">{{ $item->quantity }}x {{ $item->product ? $item->product->name : 'Unknown Product' }}</span>
                            <span class="font-medium text-stone-800 dark:text-stone-300">Rp {{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="border-t border-stone-100 dark:border-stone-800 mt-4 pt-4 flex justify-between items-center">
                        <span class="font-bold text-stone-800 dark:text-stone-200">Total</span>
                        <span class="font-bold text-amber-600 text-lg">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <p class="text-stone-500">No orders found.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
