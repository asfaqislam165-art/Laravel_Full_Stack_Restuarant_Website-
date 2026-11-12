@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-[#173C32]">Orders Management</h1>
    <a href="{{ route('admin.manual-orders.create') }}" class="bg-[#173C32] text-[#C6A15B] px-5 py-2.5 text-xs uppercase font-bold">
        + Manual Phone/WhatsApp Order
    </a>
</div>

<!-- Search & Filter Bar -->
<form method="GET" class="bg-white p-4 mb-6 shadow-sm grid grid-cols-1 md:grid-cols-5 gap-3">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Order #, Name, Phone..." class="border-gray-300 text-sm">
    <select name="order_status" class="border-gray-300 text-sm">
        <option value="">All Order Statuses</option>
        @foreach(['Pending', 'Confirmed', 'Preparing', 'Ready for Pickup', 'Out for Delivery', 'Completed', 'Cancelled'] as $st)
            <option value="{{ $st }}" @selected(request('order_status') === $st)>{{ $st }}</option>
        @endforeach
    </select>
    <select name="payment_status" class="border-gray-300 text-sm">
        <option value="">All Payment Statuses</option>
        @foreach(['Unpaid', 'Paid', 'Refunded'] as $pst)
            <option value="{{ $pst }}" @selected(request('payment_status') === $pst)>{{ $pst }}</option>
        @endforeach
    </select>
    <input type="date" name="date" value="{{ request('date') }}" class="border-gray-300 text-sm">
    <button type="submit" class="bg-[#244D40] text-white text-xs uppercase font-bold">Filter</button>
</form>

<div class="bg-white p-6 shadow-sm overflow-x-auto">
    <table class="w-full text-left text-sm">
        <thead class="border-b text-xs uppercase text-gray-500">
            <tr>
                <th class="py-3">Order #</th>
                <th>Customer</th>
                <th>Type</th>
                <th>Total</th>
                <th>Order Status</th>
                <th>Payment</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($orders as $order)
            <tr>
                <td class="py-3 font-bold">
                    {{ $order->order_number }}
                    @if($order->is_manual) <span class="text-[10px] bg-gray-200 px-1.5 py-0.5 rounded">Manual</span> @endif
                </td>
                <td>{{ $order->customer_name }}<br><span class="text-xs text-gray-500">{{ $order->phone }}</span></td>
                <td class="capitalize">{{ $order->order_type }}</td>
                <td class="font-bold">${{ number_format($order->total, 2) }}</td>
                <td><span class="px-2 py-1 bg-amber-100 text-amber-900 text-xs font-bold rounded">{{ $order->order_status }}</span></td>
                <td><span class="px-2 py-1 {{ $order->payment_status === 'Paid' ? 'bg-green-100 text-green-900' : 'bg-red-100 text-red-900' }} text-xs font-bold rounded">{{ $order->payment_status }}</span></td>
                <td class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y h:i A') }}</td>
                <td class="flex gap-3 py-3">
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-[#173C32] font-bold underline">Details</a>
                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Delete this order?')">
                        @csrf @method('DELETE')
                        <button class="text-red-700 text-xs hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">{{ $orders->links() }}</div>
</div>
@endsection