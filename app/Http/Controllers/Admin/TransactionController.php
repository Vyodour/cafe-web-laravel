<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Order;
use App\Traits\HasJsonLogging;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    use HasJsonLogging;

    public function index()
    {
        $this->logAction('view_transactions_list');
        $transactions = Transaction::with('order')->latest()->paginate(10);
        return view('admin.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $this->logAction('view_transaction_details', ['transaction_id' => $transaction->id]);
        return view('admin.transactions.show', compact('transaction'));
    }
    
    // Usually transactions are created automatically when paying an order, 
    // but Admin might need to manually record one.
    public function create()
    {
        // Assuming we select an unpaid order
        $orders = Order::whereDoesntHave('transaction')->where('status', '!=', 'cancelled')->get();
        if (request()->ajax() || request('ajax')) {
            return view('admin.transactions.partials.create-form', compact('orders'))->render();
        }
        return view('admin.transactions.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id|unique:transactions,order_id',
            'payment_method' => 'required|string',
            'amount_paid' => 'required|numeric|min:0',
        ]);

        $order = Order::find($validated['order_id']);
        
        // Basic validation that amount covers total
        if ($validated['amount_paid'] < $order->total_price) {
            return back()->withErrors(['amount_paid' => 'Amount paid is less than order total.']);
        }

        $transaction = Transaction::create([
            'order_id' => $order->id,
            'payment_method' => $validated['payment_method'],
            'gross_amount' => $order->total_price, // Changed 'amount' to 'gross_amount'
            'payment_status' => 'settlement', // Assuming paid means settlement
        ]);
        
        $order->update(['status' => 'completed']); // Assuming paid means completed

        $this->logAction('create_transaction', ['transaction_id' => $transaction->id, 'amount' => $transaction->gross_amount]);

        return redirect()->route('admin.transactions.index')->with('success', 'Transaction recorded successfully.');
    }
}
