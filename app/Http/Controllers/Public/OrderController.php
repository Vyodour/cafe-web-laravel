<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Transaction as MidtransTransaction;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['orderItems.product', 'transaction'])
            ->latest()
            ->get();
            
        return view('public.orders.index', compact('orders'));
    }

    public function checkStatus(Order $order)
    {
        // Ensure user owns this order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$order->transaction) {
             return back()->with('error', 'No transaction found for this order.');
        }

        // Configure Midtrans
        Config::$serverKey = trim(config('services.midtrans.server_key'));
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        try {
            $status = MidtransTransaction::status($order->transaction->reference_number);
            $transaction = $status->transaction_status;
            $type = $status->payment_type;
            $orderId = $status->order_id;
            $fraud = $status->fraud_status;

            // Update Logic (Simplified version of PaymentNotificationController)
            DB::beginTransaction();

            $dbTransaction = $order->transaction;

            if ($transaction == 'capture') {
                if ($fraud == 'challenge') {
                    $dbTransaction->update(['payment_status' => 'pending']);
                    $order->update(['status' => 'pending']);
                } else if ($fraud == 'accept') {
                    $dbTransaction->update(['payment_status' => 'paid']);
                    $order->update(['status' => 'processing']);
                }
            } else if ($transaction == 'settlement') {
                $dbTransaction->update(['payment_status' => 'paid']);
                $order->update(['status' => 'processing']);
            } else if ($transaction == 'cancel' || $transaction == 'deny' || $transaction == 'expire') {
                $dbTransaction->update(['payment_status' => 'failed']);
                $order->update(['status' => 'cancelled']);
            } else if ($transaction == 'pending') {
                $dbTransaction->update(['payment_status' => 'pending']);
                $order->update(['status' => 'pending']);
            }

            DB::commit();

            return back()->with('success', 'Order status updated to: ' . $transaction);

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to check status: ' . $e->getMessage());
        }
    }
}
