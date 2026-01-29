<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Add item to cart
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::with('cafe')->find($request->product_id);
        $cart = Session::get('cart', []);

        // Check Cafe Consistency
        if (!empty($cart) && isset($cart['cafe_id']) && $cart['cafe_id'] != $product->cafe_id) {
            $cart = [
                'cafe_id' => $product->cafe_id,
                'items' => []
            ];
        }

        if (empty($cart)) {
            $cart = [
                'cafe_id' => $product->cafe_id,
                'items' => []
            ];
        }

        // Add or Update Item
        if (isset($cart['items'][$product->id])) {
            $cart['items'][$product->id]['quantity'] += $request->quantity;
        } else {
            $cart['items'][$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->discount_price ?? $product->price,
                'original_price' => $product->price,
                'image_url' => $product->image_url,
                'quantity' => $request->quantity,
                'cafe_slug' => $product->cafe->slug
            ];
        }

        Session::put('cart', $cart);

        return response()->json([
            'message' => 'Product added to cart',
            'cart_count' => count($cart['items']),
            'cart_total' => $this->calculateTotal($cart),
            'cart_html' => view('public.cafes.partials.cart-sidebar', compact('cart'))->render() // Optional: render partial
        ]);
    }

    // Update quantity
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:0'
        ]);

        $cart = Session::get('cart', []);
        
        if (isset($cart['items'][$request->product_id])) {
            if ($request->quantity > 0) {
                $cart['items'][$request->product_id]['quantity'] = $request->quantity;
            } else {
                unset($cart['items'][$request->product_id]);
            }
            Session::put('cart', $cart);
        }

        // If empty, clear cafe_id
        if (empty($cart['items'])) {
            Session::forget('cart');
            $cart = [];
        }

        return response()->json([
            'message' => 'Cart updated',
            'cart_total' => $this->calculateTotal($cart),
            'cart_html' => view('public.cafes.partials.cart-sidebar', compact('cart'))->render()
        ]);
    }

    public function destroy()
    {
        Session::forget('cart');
        return response()->json(['message' => 'Cart cleared']);
    }

    private function calculateTotal($cart)
    {
        if (empty($cart['items'])) return 0;
        
        $total = 0;
        foreach ($cart['items'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}
