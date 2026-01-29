<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = trim(config('services.midtrans.server_key'));
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function store(Request $request)
    {
        $cart = Session::get('cart');

        if (empty($cart) || empty($cart['items'])) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        $user = auth()->user();
        
        $totalPrice = 0;
        foreach ($cart['items'] as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        $taxAmount = 0; 

        DB::beginTransaction();
        try {
            // Create Order
            $order = Order::create([
                'user_id' => $user->id,
                'cafe_id' => $cart['cafe_id'],
                'table_id' => null,
                'type' => 'online',
                'status' => 'pending',
                'total_price' => $totalPrice, 
                'tax_amount' => $taxAmount,
            ]);

            // Create Order Items
            foreach ($cart['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'notes' => '',
                ]);
            }

            // Create Transaction Record
            $refNumber = 'TRX-' . strtoupper(Str::random(10));
            
            // Midtrans Params
            $params = [
                'transaction_details' => [
                    'order_id' => $refNumber,
                    'gross_amount' => (int) $totalPrice,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
                'item_details' => array_values(array_map(function($item) {
                    return [
                        'id' => $item['id'],
                        'price' => (int) $item['price'],
                        'quantity' => $item['quantity'],
                        'name' => substr($item['name'], 0, 50),
                    ];
                }, $cart['items'])),
                'callbacks' => [
                    'finish' => route('public.cafes.index'), // Temp redirect
                ]
            ];

            $snapToken = Snap::getSnapToken($params);

            Transaction::create([
                'order_id' => $order->id,
                'payment_method' => 'midtrans',
                'reference_number' => $refNumber,
                'payment_status' => 'pending',
                'snap_token' => $snapToken,
                'gross_amount' => $totalPrice,
                'transaction_time' => now(),
            ]);

            DB::commit();
            
            // Clear Cart
            Session::forget('cart');

            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $order->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Checkout Error: ' . $e->getMessage());
            \Illuminate\Support\Facades\Log::error('Midtrans Config: isProduction=' . (Config::$isProduction ? 'true' : 'false'));
            \Illuminate\Support\Facades\Log::error('Midtrans Config: ServerKeyPrefix=' . substr(Config::$serverKey, 0, 20) . '...');
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
