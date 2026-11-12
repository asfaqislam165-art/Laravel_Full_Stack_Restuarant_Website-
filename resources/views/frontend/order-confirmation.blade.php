@extends('layouts.app')
@section('title', 'Order Confirmation')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 py-10 sm:py-16">
    <div class="bg-white border-t-4 border-[#C6A15B] p-6 sm:p-8 md:p-12 shadow-lg">
        <!-- Header & Order Status -->
        <div class="text-center border-b pb-6 sm:pb-8 mb-6 sm:mb-8">
            <span class="inline-block bg-[#173C32] text-[#C6A15B] text-xs uppercase tracking-widest px-4 py-1.5 font-bold mb-3">
                Order Status: {{ $order->order_status }}
            </span>
            <h1 class="font-serif-luxury text-3xl sm:text-4xl md:text-5xl text-forest font-bold mt-2 mb-2">Thank You, {{ $order->customer_name }}</h1>
            <p class="text-xs sm:text-sm text-gray-600 px-2">Your order number is <strong class="text-forest">{{ $order->order_number }}</strong>. Your order remains <strong>Pending</strong> until confirmed by our kitchen team.</p>
        </div>

        <!-- Direct Phone & WhatsApp Action Buttons -->
        <div class="bg-ivory p-5 sm:p-6 border border-[#C6A15B]/40 mb-6 sm:mb-8 text-center shadow-sm">
            <p class="text-xs uppercase tracking-widest text-forest font-bold mb-3 sm:mb-4">Expedite Confirmation via Phone or WhatsApp</p>
            <div class="flex flex-col sm:flex-row justify-center gap-3 sm:gap-4">
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings->phone) }}"
                   class="bg-forest text-white hover:bg-[#244D40] px-6 py-3 text-xs uppercase tracking-widest font-bold transition text-center">
                    Call Restaurant ({{ $settings->phone }})
                </a>
                <a href="{{ $whatsappUrl }}" target="_blank"
                   class="bg-[#25D366] text-white hover:opacity-90 px-6 py-3 text-xs uppercase tracking-widest font-bold transition text-center">
                    Send Order via WhatsApp
                </a>
            </div>
            <p class="text-[11px] text-gray-500 mt-3 px-2">Clicking WhatsApp opens a pre-filled summary of your order for you to send directly to our concierge.</p>
        </div>

        <!-- Order Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm mb-6 sm:mb-8 border-b pb-6">
            <div>
                <h3 class="font-bold uppercase text-xs text-gray-400 mb-1">Customer & Fulfillment</h3>
                <p class="font-semibold text-gray-800">{{ $order->customer_name }} ({{ $order->phone }})</p>
                <p class="capitalize text-gray-700">Type: <strong>{{ $order->order_type }}</strong></p>
                @if($order->order_type === 'delivery')
                    <p class="text-gray-600 mt-1">{{ $order->address }}, {{ $order->city }}, {{ $order->state }} {{ $order->zip_code }}</p>
                @endif
            </div>
            <div class="mt-2 md:mt-0">
                <h3 class="font-bold uppercase text-xs text-gray-400 mb-1">Payment Summary</h3>
                <p class="text-gray-700">Method: <strong>{{ $order->payment_method }}</strong></p>
                <p class="text-gray-700">Payment Status: <span class="text-amber-700 font-bold">{{ $order->payment_status }}</span></p>
            </div>
        </div>

        <!-- Ordered Dishes -->
        <h3 class="font-serif-luxury text-xl sm:text-2xl font-bold text-forest mb-4">Ordered Dishes</h3>
        <div class="space-y-3 text-sm border-b pb-4 mb-4">
            @foreach($order->items as $item)
            <div class="flex justify-between items-start gap-3">
                <span class="text-gray-700">{{ $item->quantity }}x {{ $item->item_name }} <span class="text-xs text-gray-500">($${{ number_format($item->unit_price, 2) }})</span></span>
                <span class="font-semibold text-gray-800 shrink-0">${{ number_format($item->total_price, 2) }}</span>
            </div>
            @endforeach
        </div>

        <!-- Final Calculation Summary -->
        <div class="space-y-1.5 text-sm text-right text-gray-700">
            <p>Subtotal: <strong class="text-gray-900">${{ number_format($order->subtotal, 2) }}</strong></p>
            @if($order->discount > 0)
                <p class="text-emerald-700 font-semibold">Discount: -${{ number_format($order->discount, 2) }}</p>
            @endif
            <p>Delivery Fee: <span class="font-semibold text-gray-900">${{ number_format($order->delivery_fee, 2) }}</span></p>
            <p class="text-lg sm:text-xl font-bold text-forest pt-2 border-t border-gray-100 mt-2">Total Due: ${{ number_format($order->total, 2) }}</p>
        </div>
    </div>
</div>
@endsection