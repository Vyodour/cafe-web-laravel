<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Table;
use App\Models\Product;
use App\Traits\HasJsonLogging;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use HasJsonLogging;

    public function index()
    {
        $this->logAction('view_orders_list');
        $orders = Order::with(['table', 'user', 'orderItems.product'])->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->logAction('view_order_details', ['order_id' => $order->id]);
        $order->load(['orderItems.product', 'table', 'user', 'transaction']);
        if (request()->ajax() || request('ajax')) {
            return view('admin.orders.partials.show-details', compact('order'))->render();
        }
        return view('admin.orders.show', compact('order'));
    }

    /*
    public function create()
    {
        // Admin creations disabled as per requirement
        $tables = Table::where('status', 'active')->get();
        $products = Product::where('is_available', true)->get();
        if (request()->ajax() || request('ajax')) {
            return view('admin.orders.create', compact('tables', 'products'))->render();
        }
        return view('admin.orders.create', compact('tables', 'products'));
    }

    public function store(Request $request)
    {
         // Disabled
    }
    */

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update($validated);

        $this->logAction('update_order_status', ['order_id' => $order->id, 'status' => $order->status]);

        return redirect()->route('admin.orders.index')->with('success', 'Order status updated.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        $this->logAction('delete_order', ['order_id' => $order->id]);
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted.');
    }
}
