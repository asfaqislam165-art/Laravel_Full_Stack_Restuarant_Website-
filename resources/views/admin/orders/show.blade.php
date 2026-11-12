@extends('layouts.admin')

@section('content')
<div class="flex flex-wrap justify-between items-center gap-4 mb-6">
    <div>
        <a href="{{ route('admin.orders.index') }}" class="text-xs text-gray-500 hover:underline">&larr; Back to All Orders</a>
        <h1 class="text-3xl font-bold text-[#173C32]">Order {{ $order->order_number }}</h1>
    </div>
    <div class="flex gap-3">
        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $order->phone) }}" class="bg-[#173C32] text-white px-4 py-2 text-xs uppercase font-bold">
            Call Customer
        </a>
        <a href="{{ $customerWhatsappUrl }}" target="_blank" class="bg-[#25D366] text-white px-4 py-2 text-xs uppercase font-bold">
            WhatsApp Customer
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 bg-white p-6 shadow-sm space-y-6">
        <h2 class="text-lg font-bold border-b pb-2">Ordered Items</h2>
        <table class="w-full text-sm">
            <thead class="text-left text-xs uppercase text-gray-500 border-b">
                <tr>
                    <th class="py-2">Dish</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($order->items as $item)
                <tr>
                    <td class="py-3 font-semibold">{{ $item->item_name }}</td>
                    <td>${{ number_format($item->unit_price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td class="text-right font-bold">${{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-right text-sm space-y-1 pt-4 border-t">
            <p>Subtotal: ${{ number_format($order->subtotal, 2) }}</p>
            <p>Discount: -${{ number_format($order->discount, 2) }}</p>
            <p>Delivery Fee: ${{ number_format($order->delivery_fee, 2) }}</p>
            <p class="text-xl font-bold text-[#173C32]">Final Total: ${{ number_format($order->total, 2) }}</p>
        </div>
    </div>

    <div class="space-y-6">
        <!-- Status Update Card -->
        <div class="bg-white p-6 shadow-sm">
            <h3 class="font-bold text-[#173C32] mb-3">Update Order Status</h3>
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="space-y-3">
                @csrf @method('PATCH')
                <select name="order_status" class="w-full border-gray-300 text-sm">
                    @foreach(['Pending', 'Confirmed', 'Preparing', 'Ready for Pickup', 'Out for Delivery', 'Completed', 'Cancelled'] as $status)
                        <option value="{{ $status }}" @selected($order->order_status === $status)>{{ $status }}</option>
                    @endforeach
                </select>
                <button class="w-full bg-[#173C32] text-[#C6A15B] py-2.5 text-xs uppercase font-bold">Save Order Status</button>
            </form>
        </div>

        <!-- Manual Payment Update Card -->
        <div class="bg-white p-6 shadow-sm">
            <h3 class="font-bold text-[#173C32] mb-1">Payment Status ({{ $order->payment_method }})</h3>
            <p class="text-xs text-gray-500 mb-3">Mark Paid only after receiving cash/payment.</p>
            <form action="{{ route('admin.orders.updatePayment', $order) }}" method="POST" class="space-y-3">
                @csrf @method('PATCH')
                <select name="payment_status" class="w-full border-gray-300 text-sm">
                    @foreach(['Unpaid', 'Paid', 'Refunded'] as $pStatus)
                        <option value="{{ $pStatus }}" @selected($order->payment_status === $pStatus)>{{ $pStatus }}</option>
                    @endforeach
                </select>
                <button class="w-full bg-[#C6A15B] text-[#173C32] py-2.5 text-xs uppercase font-bold">Update Payment</button>
            </form>
        </div>

        <!-- Customer Info -->
        <div class="bg-white p-6 shadow-sm text-sm space-y-1">
            <h3 class="font-bold text-[#173C32] mb-2">Customer Information</h3>
            <p><strong>Name:</strong> {{ $order->customer_name }}</p>
            <p><strong>Phone:</strong> {{ $order->phone }}</p>
            @if($order->whatsapp)<p><strong>WhatsApp:</strong> {{ $order->whatsapp }}</p>@endif
            @if($order->email)<p><strong>Email:</strong> {{ $order->email }}</p>@endif
            <p class="capitalize"><strong>Order Type:</strong> {{ $order->order_type }}</p>
            @if($order->order_type === 'delivery')
                <p><strong>Address:</strong> {{ $order->address }}, {{ $order->city }}, {{ $order->state }} {{ $order->zip_code }}</p>
                @if($order->delivery_instructions)<p><strong>Instructions:</strong> {{ $order->delivery_instructions }}</p>@endif
            @endif
            @if($order->order_notes)<p><strong>Kitchen Notes:</strong> {{ $order->order_notes }}</p>@endif
        </div>
    </div>
</div>
@endsection