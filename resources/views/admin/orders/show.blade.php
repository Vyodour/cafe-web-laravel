@extends('layouts.admin')

@section('title', 'Order Details #' . $order->id)

@section('content')
<div class="max-w-3xl mx-auto mt-10">
    @include('admin.orders.partials.show-details')
</div>
@endsection
