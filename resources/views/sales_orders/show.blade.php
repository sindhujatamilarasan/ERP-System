@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Sales Order: {{ $order->order_number }}</h2>
    <p><strong>Total:</strong> ₹{{ $order->total }}</p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th><th>Quantity</th><th>Price</th><th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₹{{ $item->price }}</td>
                    <td>₹{{ $item->subtotal }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="text-end mt-3">
        <a href="{{ route('sales_orders.export', $order->id) }}" class="btn btn-success">Export PDF</a>
        <a href="{{ route('sales_orders.index') }}" class="btn btn-secondary">Back</a>
    </div>


</div>
@endsection
