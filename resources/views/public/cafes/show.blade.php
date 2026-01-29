@extends('layouts.public')

@section('title', $cafe->name . ' - Menu')

@section('content')
<!-- Hero Header -->
<div class="relative h-[40vh] min-h-[400px] flex items-end pb-12 overflow-hidden">
    <div class="absolute inset-0">
        <img src="{{ $cafe->image_url }}" alt="{{ $cafe->name }}" class="w-full h-full object-cover filter brightness-75 blur-[2px] scale-105">
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-stone-900/60 to-black/30"></div>
        <div class="absolute inset-0 bg-black/20"></div> {{-- Additional dark layer --}}
    </div>
    <div class="container mx-auto px-6 max-w-7xl relative z-10 text-white">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="space-y-4 animate-fade-in-up">
                <div class="flex flex-wrap gap-2">
                    @foreach($cafe->tags as $tag)
                        <span class="px-3 py-1 bg-white/20 backdrop-blur rounded-full text-xs font-semibold tracking-wide border border-white/10">{{ $tag->name }}</span>
                    @endforeach
                </div>
                <h1 class="text-5xl md:text-7xl font-bold tracking-tight">{{ $cafe->name }}</h1>
                <p class="text-lg text-white/80 max-w-xl">{{ $cafe->description }}</p>
                <div class="flex items-center gap-6 text-sm font-medium pt-2">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $cafe->address ?? $cafe->city }}
                    </span>
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Open 08:00 - 22:00
                    </span>
                </div>
            </div>
            
            <div class="hidden md:block">
                 <div class="bg-white/10 backdrop-blur-md border border-white/20 p-4 rounded-xl text-center">
                    <span class="block text-3xl font-bold text-amber-400">4.8</span>
                    <div class="flex text-amber-400 text-sm gap-0.5 my-1">
                        <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                    </div>
                    <span class="text-xs text-white/60">200+ Reviews</span>
                 </div>
            </div>
        </div>
    </div>
</div>

<!-- Menu Section -->
<div class="bg-stone-50 dark:bg-[#0c0a09] min-h-screen relative overflow-hidden" x-data="{ activeCategory: '{{ $groupedProducts->keys()->first() }}' }">
    
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5 pointer-events-none">
        <svg width="100%" height="100%">
            <pattern id="grid-menu" width="40" height="40" patternUnits="userSpaceOnUse">
                <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="0.5"/>
            </pattern>
            <rect width="100%" height="100%" fill="url(#grid-menu)" />
        </svg>
    </div>
    
    <!-- Sticky Category Nav -->
    <div class="sticky top-[72px] z-30 bg-white/80 dark:bg-stone-900/80 backdrop-blur border-b border-stone-200 dark:border-stone-800 shadow-sm overflow-x-auto">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="flex whitespace-nowrap gap-8">
                @foreach($groupedProducts as $category => $products)
                <button 
                    @click="activeCategory = '{{ $category }}'; document.getElementById('{{ Str::slug($category) }}').scrollIntoView({ behavior: 'smooth', block: 'center' })"
                    class="py-4 text-sm font-bold uppercase tracking-wider border-b-2 transition-colors hover-target"
                    :class="activeCategory === '{{ $category }}' ? 'border-amber-600 text-amber-900 dark:text-amber-500' : 'border-transparent text-stone-500 hover:text-stone-800 dark:hover:text-stone-300'"
                >
                    {{ $category }}
                </button>
                @endforeach
            </div>
        </div>
    </div>

    <div class="container mx-auto px-6 max-w-7xl py-12 grid grid-cols-1 lg:grid-cols-4 gap-12">
        
        <!-- Product Grid -->
        <div class="lg:col-span-3 space-y-16">
            @foreach($groupedProducts as $category => $products)
            <div id="{{ Str::slug($category) }}" class="scroll-mt-32" x-intersect.threshold.0.5="activeCategory = '{{ $category }}'">
                <h3 class="text-2xl font-bold text-amber-950 dark:text-amber-50 mb-6 flex items-center gap-3">
                    {{ $category }}
                    <span class="h-px flex-1 bg-stone-200 dark:bg-stone-800"></span>
                </h3>

                <div class="grid md:grid-cols-2 gap-6">
                    @foreach($products as $product)
                    <div class="group bg-white dark:bg-stone-900 rounded-2xl p-4 border border-stone-100 dark:border-stone-800 hover:border-amber-200 dark:hover:border-amber-900 transition-all hover:shadow-lg flex gap-4 hover-target">
                        <div class="w-32 h-32 shrink-0 rounded-xl overflow-hidden relative">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            
                            <!-- Badges -->
                            <div class="absolute top-2 left-2 flex flex-col gap-1 items-start">
                                @if($product->created_at->diffInDays(now()) < 7)
                                    <span class="px-2 py-0.5 rounded bg-blue-500 text-white text-[10px] font-bold uppercase tracking-wide shadow-sm">New</span>
                                @endif
                                @if($product->discount_price)
                                    <span class="px-2 py-0.5 rounded bg-red-500 text-white text-[10px] font-bold uppercase tracking-wide shadow-sm">Promo</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <h4 class="font-bold text-amber-950 dark:text-gray-100 text-lg sm:text-lg mb-1 group-hover:text-amber-700 transition-colors">{{ $product->name }}</h4>
                                <p class="text-stone-500 text-sm line-clamp-2">{{ $product->description }}</p>
                            </div>
                            
                            <div class="flex items-center justify-between mt-3">
                                <div>
                                    @if($product->discount_price)
                                        <span class="text-xs text-stone-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <span class="block text-amber-700 dark:text-amber-400 font-bold">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                                    @else
                                        <span class="block text-amber-700 dark:text-amber-400 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                                
                                <button onclick="addToCart('{{ $product->id }}')" class="w-10 h-10 rounded-full bg-stone-100 dark:bg-stone-800 flex items-center justify-center text-amber-900 dark:text-amber-500 hover:bg-amber-900 hover:text-white transition-colors hover-target" title="Add to Order">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- Sidebar Cart -->
        <div class="hidden lg:block lg:col-span-1" id="cart-container">
            @include('public.cafes.partials.cart-sidebar', ['cart' => session('cart')])
        </div>

    </div>
</div>

<!-- Midtrans Snap Script -->
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

<script>
    // Cart Logic
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    function addToCart(productId) {
        fetch('{{ route('cart.add') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ product_id: productId, quantity: 1 })
        })
        .then(response => response.json())
        .then(data => {
            if(data.cart_html) {
                document.getElementById('cart-container').innerHTML = data.cart_html;
            }
            // Optional: Toast notification
        });
    }

    function updateCart(productId, quantity) {
        fetch('{{ route('cart.update') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ product_id: productId, quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if(data.cart_html) {
                document.getElementById('cart-container').innerHTML = data.cart_html;
            }
        });
    }

    function clearCart() {
       fetch('{{ route('cart.clear') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
             // Reset UI (could request partial or just hard reload)
             location.reload(); 
        });
    }

    function checkout() {
        @auth
            fetch('{{ route('checkout.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => {
                if(response.status === 401) {
                    window.location.href = '{{ route('login') }}';
                    return;
                }
                return response.json();
            })
            .then(data => {
                if(data.snap_token) {
                    snap.pay(data.snap_token, {
                        onSuccess: function(result){ alert("Payment success!"); location.reload(); },
                        onPending: function(result){ alert("Waiting for payment!"); location.reload(); },
                        onError: function(result){ alert("Payment failed!"); }
                    });
                } else {
                    alert('Checkout failed: ' + (data.error || 'Unknown error'));
                }
            });
        @else
            window.location.href = '{{ route('login') }}'; 
        @endauth
    }
</script>
@endsection
