@if(empty($cart) || empty($cart['items']))
    <div class="sticky top-32 bg-white dark:bg-stone-900 p-6 rounded-2xl border border-stone-100 dark:border-stone-800 shadow-sm">
        <h3 class="font-bold text-lg mb-4 text-amber-950 dark:text-white">Your Order</h3>
        <div class="text-center py-8 text-stone-500">
            <svg class="w-12 h-12 mx-auto mb-3 text-stone-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            <p class="text-sm">Your basket is empty.</p>
            <p class="text-xs mt-1">Start adding items to order.</p>
        </div>
    </div>
@else
    <div class="sticky top-32 bg-white dark:bg-stone-900 p-6 rounded-2xl border border-stone-100 dark:border-stone-800 shadow-sm">
        <div class="flex items-center justify-between mb-4">
             <h3 class="font-bold text-lg text-amber-950 dark:text-white">Your Order</h3>
             <button onclick="clearCart()" class="text-xs text-red-500 hover:underline">Clear</button>
        </div>

        <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-1">
            @foreach($cart['items'] as $item)
            <div class="flex gap-3">
                <div class="w-12 h-12 rounded-md bg-stone-100 overflow-hidden shrink-0">
                    <img src="{{ $item['image_url'] ?? 'https://via.placeholder.com/50' }}" class="w-full h-full object-cover">
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                         <h4 class="text-sm font-semibold text-amber-950 dark:text-stone-200 line-clamp-1">{{ $item['name'] }}</h4>
                         <span class="text-xs font-bold text-stone-600 dark:text-stone-400">x{{ $item['quantity'] }}</span>
                    </div>
                    <div class="flex justify-between items-center mt-1">
                        <span class="text-xs text-stone-500">Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                        <div class="flex items-center gap-2">
                            <button onclick="updateCart('{{ $item['id'] }}', {{ $item['quantity'] - 1 }})" class="w-5 h-5 rounded-full bg-stone-100 dark:bg-stone-800 flex items-center justify-center text-xs hover:bg-amber-100 dark:hover:bg-amber-900">-</button>
                            <button onclick="updateCart('{{ $item['id'] }}', {{ $item['quantity'] + 1 }})" class="w-5 h-5 rounded-full bg-stone-100 dark:bg-stone-800 flex items-center justify-center text-xs hover:bg-amber-100 dark:hover:bg-amber-900">+</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="border-t border-stone-100 dark:border-stone-800 mt-6 pt-4 space-y-2">
            <div class="flex justify-between text-sm">
                <span class="text-stone-500">Subtotal</span>
                <span class="font-bold text-stone-800 dark:text-stone-200" id="cart-total-display">Rp {{ number_format(collect($cart['items'])->sum(fn($i) => $i['price'] * $i['quantity']), 0, ',', '.') }}</span>
            </div>
            <button onclick="checkout()" class="w-full mt-4 bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 rounded-xl transition-colors shadow-lg shadow-amber-600/20 flex items-center justify-center gap-2">
                Pay Now
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </button>
        </div>
    </div>
@endif
