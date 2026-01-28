@extends('layouts.admin')

@section('title', 'Transaction Details')

@section('content')
<div class="max-w-xl mx-auto mt-10 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Transaction #{{ $transaction->id }}</h2>
        <a href="{{ route('admin.transactions.index') }}" class="text-blue-500 hover:text-blue-800">Back to List</a>
    </div>

    <div class="space-y-4">
        <div class="border-b pb-2">
            <label class="block text-gray-500 text-sm uppercase">Order</label>
            <a href="{{ route('admin.orders.show', $transaction->order_id) }}" class="text-blue-600 font-bold hover:underline">
                Order #{{ $transaction->order_id }}
            </a>
        </div>
         <div class="border-b pb-2">
            <label class="block text-gray-500 text-sm uppercase">Amount</label>
            <span class="text-xl font-bold text-green-600">${{ number_format($transaction->amount, 2) }}</span>
        </div>
        <div class="border-b pb-2">
            <label class="block text-gray-500 text-sm uppercase">Payment Method</label>
            <span class="capitalize font-medium">{{ $transaction->payment_method }}</span>
        </div>
        <div class="border-b pb-2">
            <label class="block text-gray-500 text-sm uppercase">Status</label>
            <span class="uppercase font-bold text-green-600">{{ $transaction->status }}</span>
        </div>
         <div>
            <label class="block text-gray-500 text-sm uppercase">Date</label>
            <span class="font-medium">{{ $transaction->created_at->format('F d, Y h:i A') }}</span>
        </div>
    </div>
</div>
@endsection
