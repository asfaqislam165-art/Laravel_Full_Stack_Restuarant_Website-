@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 sm:py-16">
    <h1 class="font-serif-luxury text-3xl sm:text-4xl md:text-5xl text-forest font-bold mb-6 sm:mb-8">Complete Your Order</h1>

    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-700 p-4 mb-6 text-sm text-red-800 shadow-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('checkout.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10">
        @csrf
        <div class="lg:col-span-2 bg-white p-6 sm:p-8 border border-[#173C32]/10 space-y-6 shadow-sm">
            <h2 class="font-serif-luxury text-xl sm:text-2xl font-bold text-forest border-b pb-2">1. Dining Preference</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <label class="border p-4 cursor-pointer flex items-center gap-3 transition hover:bg-gray-50">
                    <input type="radio" name="order_type" value="delivery" checked onchange="toggleOrderType('delivery')">
                    <div>
                        <span class="font-bold block text-forest text-sm sm:text-base">Delivery</span>
                        <span class="text-xs text-gray-500">Cash on Delivery (+${{ number_format($settings->delivery_fee, 2) }})</span>
                    </div>
                </label>
                <label class="border p-4 cursor-pointer flex items-center gap-3 transition hover:bg-gray-50">
                    <input type="radio" name="order_type" value="pickup" onchange="toggleOrderType('pickup')">
                    <div>
                        <span class="font-bold block text-forest text-sm sm:text-base">Restaurant Pickup</span>
                        <span class="text-xs text-gray-500">Pay at Pickup ($0.00 Fee)</span>
                    </div>
                </label>
            </div>

            <h2 class="font-serif-luxury text-xl sm:text-2xl font-bold text-forest border-b pb-2 pt-2">2. Guest Contact Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase mb-1">Full Name *</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name') }}" required class="w-full border-gray-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase mb-1">Phone Number *</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="(212) 555-0199" required class="w-full border-gray-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase mb-1">WhatsApp Number (Optional)</label>
                    <input type="tel" name="whatsapp" value="{{ old('whatsapp') }}" class="w-full border-gray-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase mb-1">Email Address (Optional)</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full border-gray-300 px-3 py-2 text-sm">
                </div>
            </div>

            <div id="deliveryFields" class="space-y-4 pt-2">
                <h2 class="font-serif-luxury text-xl sm:text-2xl font-bold text-forest border-b pb-2">3. Delivery Address</h2>
                <div>
                    <label class="block text-xs font-bold uppercase mb-1">Street Address *</label>
                    <input type="text" name="address" value="{{ old('address') }}" class="w-full border-gray-300 px-3 py-2 text-sm">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase mb-1">City *</label>
                        <input type="text" name="city" value="{{ old('city', 'New York') }}" class="w-full border-gray-300 px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase mb-1">State *</label>
                        <input type="text" name="state" value="{{ old('state', 'NY') }}" class="w-full border-gray-300 px-3 py-2 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase mb-1">ZIP Code *</label>
                        <input type="text" name="zip_code" value="{{ old('zip_code') }}" class="w-full border-gray-300 px-3 py-2 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase mb-1">Delivery Instructions</label>
                    <input type="text" name="delivery_instructions" value="{{ old('delivery_instructions') }}" placeholder="Doorman, suite number, gate code..." class="w-full border-gray-300 px-3 py-2 text-sm">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase mb-1">Kitchen / Order Notes</label>
                <textarea name="order_notes" rows="2" placeholder="Steak temperature (e.g., Medium-Rare), allergies..." class="w-full border-gray-300 px-3 py-2 text-sm">{{ old('order_notes') }}</textarea>
            </div>

            <div class="bg-ivory p-4 border border-[#C6A15B]/50">
                <h3 class="font-bold text-xs sm:text-sm text-forest uppercase mb-1">Payment Method (Manual Settlement Only)</h3>
                <p id="paymentMethodLabel" class="text-xs sm:text-sm text-gray-700">Cash on Delivery — Pay upon receiving your order.</p>
                <input type="hidden" name="payment_method" id="paymentMethodInput" value="Cash on Delivery">
            </div>
        </div>

        <!-- Final Order Review -->
        <div class="bg-white p-5 sm:p-6 border border-[#173C32]/15 h-fit shadow-sm">
            <h2 class="font-serif-luxury text-xl sm:text-2xl font-bold text-forest border-b pb-3 mb-4">Order Summary</h2>
            <div class="space-y-3 border-b pb-4 mb-4 text-sm">
                @foreach($validatedCart as $item)
                <div class="flex justify-between gap-2">
                    <span class="text-gray-700">{{ $item['quantity'] }}x {{ $item['name'] }}</span>
                    <span class="font-semibold shrink-0">${{ number_format($item['line_total'], 2) }}</span>
                </div>
                @endforeach
            </div>

            <div class="space-y-2 text-sm border-b pb-4 mb-4">
                <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-semibold">${{ number_format($subtotal, 2) }}</span>
                </div>
                @if($discount > 0)
                <div class="flex justify-between text-emerald-700 font-semibold">
                    <span>Discount</span>
                    <span>-${{ number_format($discount, 2) }}</span>
                </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-gray-600">Delivery Charge</span>
                    <span class="font-semibold" id="summaryDeliveryFee">${{ number_format($deliveryFee, 2) }}</span>
                </div>
            </div>

            <div class="flex justify-between text-lg sm:text-xl font-bold text-forest mb-6">
                <span>Final Total</span>
                <span id="summaryTotal">${{ number_format($total, 2) }}</span>
            </div>

            <button type="submit" class="w-full bg-forest text-white hover:bg-[#C6A15B] hover:text-[#173C32] py-3 sm:py-4 text-xs uppercase tracking-widest font-bold transition">
                Place Order
            </button>
        </div>
    </form>
</div>

<script>
    const subtotal = {{ $subtotal }};
    const discount = {{ $discount }};
    const baseDelivery = {{ $settings->delivery_fee }};

    function toggleOrderType(type) {
        const deliveryFields = document.getElementById('deliveryFields');
        const feeEl = document.getElementById('summaryDeliveryFee');
        const totalEl = document.getElementById('summaryTotal');
        const payLabel = document.getElementById('paymentMethodLabel');
        const payInput = document.getElementById('paymentMethodInput');

        if (type === 'delivery') {
            deliveryFields.style.display = 'block';
            feeEl.innerText = '$' + baseDelivery.toFixed(2);
            totalEl.innerText = '$' + Math.max(0, subtotal - discount + baseDelivery).toFixed(2);
            payLabel.innerText = 'Cash on Delivery — Pay upon receiving your order.';
            payInput.value = 'Cash on Delivery';
        } else {
            deliveryFields.style.display = 'none';
            feeEl.innerText = '$0.00';
            totalEl.innerText = '$' + Math.max(0, subtotal - discount).toFixed(2);
            payLabel.innerText = 'Pay at Pickup — Settle directly at the restaurant counter.';
            payInput.value = 'Pay at Pickup';
        }
    }
</script>
@endsection