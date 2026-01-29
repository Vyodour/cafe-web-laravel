<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;

class PaymentNotificationController extends Controller
{
    public function __construct()
    {
        // Configure Midtrans Config
        Config::$serverKey = trim(config('services.midtrans.server_key'));
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function handle(Request $request)
    {
        try {
            $payload = $request->all();
            
            Log::info('Midtrans Notification received', $payload);

            $orderId = $payload['order_id'];
            $transactionStatus = $payload['transaction_status'];
            $fraudStatus = $payload['fraud_status'] ?? null;

            $transaction = Transaction::where('reference_number', $orderId)->first();

            if (!$transaction) {
                Log::error("Transaction not found for order_id: $orderId");
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            $order = $transaction->order;
            
            DB::beginTransaction();

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $transaction->update(['payment_status' => 'pending']);
                    $order->update(['status' => 'pending']);
                } else if ($fraudStatus == 'accept') {
                    $transaction->update(['payment_status' => 'paid']);
                    $order->update(['status' => 'processing']);
                }
            } else if ($transactionStatus == 'settlement') {
                $transaction->update(['payment_status' => 'paid']);
                $order->update(['status' => 'processing']);
            } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
                $transaction->update(['payment_status' => 'failed']);
                $order->update(['status' => 'cancelled']);
            } else if ($transactionStatus == 'pending') {
                $transaction->update(['payment_status' => 'pending']);
                $order->update(['status' => 'pending']);
            }

            DB::commit();
            Log::info("Transaction $orderId updated to status: $transactionStatus");

            return response()->json(['message' => 'Notification processed']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment Notification Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error processing notification'], 500);
        }
    }
}
