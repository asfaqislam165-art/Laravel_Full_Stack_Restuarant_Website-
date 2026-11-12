@extends('layouts.app')
@section('title', 'Your Order Cart')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 sm:py-16">
    <h1 class="font-serif-luxury text-3xl sm:text-4xl md:text-5xl text-forest font-bold mb-6 sm:mb-8">Your Dining Order</h1>

    @if(empty($validatedCart))
        <div class="bg-white p-8 sm:p-12 text-center border border-[#173C32]/10 shadow-sm">
            <p class="text-gray-600 mb-6 text-sm sm:text-base">Your order cart is currently empty.</p>
            <a href="{{ route('menu') }}" class="inline-block bg-forest text-white px-6 sm:px-8 py-3 text-xs uppercase tracking-widest font-bold hover:bg-[#C6A15B] hover:text-[#173C32] transition">
                Explore Our Menu
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($validatedCart as $item)
                <div class="bg-white p-4 sm:p-5 border border-[#173C32]/10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-sm">
                    <!-- Item Info -->
                    <div class="w-full sm:w-auto">
                        <h3 class="font-serif-luxury text-xl sm:text-2xl font-bold text-forest">{{ $item['name'] }}</h3>
                        <p class="text-xs sm:text-sm text-gray-500">${{ number_format($item['price'], 2) }} each</p>
                    </div>

                    <!-- Quantity Control & Price / Remove Wrapper for Mobile Alignment -->
                    <div class="flex w-full sm:w-auto items-center justify-between sm:justify-end gap-6 pt-2 sm:pt-0 border-t sm:border-t-0 border-gray-100">
                        <!-- Quantity Controls -->
                        <div class="flex items-center space-x-2 sm:space-x-3">
                            <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <input type="hidden" name="action" value="decrease">
                                <button type="submit" class="w-8 h-8 flex items-center justify-center border border-gray-300 font-bold hover:bg-forest hover:text-white transition">-</button>
                            </form>
                            <span class="font-bold w-6 text-center text-sm sm:text-base">{{ $item['quantity'] }}</span>
                            <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <input type="hidden" name="action" value="increase">
                                <button type="submit" class="w-8 h-8 flex items-center justify-center border border-gray-300 font-bold hover:bg-forest hover:text-white transition">+</button>
                            </form>
                        </div>

                        <!-- Line Total & Remove -->
                        <div class="text-right">
                            <p class="font-bold text-forest text-base sm:text-lg">${{ number_format($item['line_total'], 2) }}</p>
                            <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs text-red-700 hover:underline mt-1 font-medium">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="pt-2 sm:pt-4">
                    <a href="{{ route('menu') }}" class="text-sm font-semibold text-forest hover:text-[#C6A15B] transition">&larr; Continue Exploring Menu</a>
                </div>
            </div>

            <!-- Order Summary & Promo Code -->
            <div class="bg-white p-5 sm:p-6 border border-[#173C32]/15 h-fit shadow-sm">
                <h2 class="font-serif-luxury text-xl sm:text-2xl font-bold text-forest border-b pb-3 mb-4">Order Summary</h2>

                <!-- Promo Form -->
                <form action="{{ route('cart.applyOffer') }}" method="POST" class="flex gap-2 mb-6">
                    @csrf
                    <input type="text" name="offer_code" placeholder="Promo Code" value="{{ $appliedOffer?->code }}"
                           class="w-full border-gray-300 text-sm uppercase px-3 py-2">
                    <button type="submit" class="bg-emerald-dark text-white px-4 py-2 text-xs uppercase font-bold shrink-0 hover:opacity-90 transition">Apply</button>
                </form>

                <div class="space-y-3 text-sm border-b pb-4 mb-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold">${{ number_format($subtotal, 2) }}</span>
                    </div>
                    @if($discount > 0)
                    <div class="flex justify-between text-emerald-700 font-semibold">
                        <span>Discount ({{ $appliedOffer->code }})</span>
                        <span>-${{ number_format($discount, 2) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-600">Estimated Delivery Fee</span>
                        <span class="font-semibold">${{ number_format($deliveryFee, 2) }}</span>
                    </div>
                </div>

                <div class="flex justify-between text-base sm:text-lg font-bold text-forest mb-6">
                    <span>Estimated Total</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>

                <a href="{{ route('checkout.index') }}" class="block text-center w-full bg-[#C6A15B] text-[#173C32] hover:bg-forest hover:text-white py-3 sm:py-4 text-xs uppercase tracking-widest font-bold transition">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    @endif
</div>
@endsection