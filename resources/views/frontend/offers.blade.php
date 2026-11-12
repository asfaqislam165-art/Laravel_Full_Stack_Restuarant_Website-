@extends('layouts.app')
@section('title', 'Special Offers')

@section('content')
<!-- Hero Section -->
<section class="bg-forest text-white py-12 sm:py-16 text-center px-4 sm:px-6">
    <span class="text-[#C6A15B] uppercase tracking-[0.2em] sm:tracking-[0.3em] text-xs font-bold">Exclusive Dining Privileges</span>
    <h1 class="font-serif-luxury text-3xl sm:text-4xl md:text-5xl font-bold mt-2 px-2">Special Offers & Promotions</h1>
</section>

<!-- Offers Grid -->
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 sm:py-16 grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
    @forelse($offers as $offer)
    <div class="bg-white border-t-4 border-[#C6A15B] p-6 sm:p-8 shadow-sm flex flex-col justify-between">
        <div>
            <!-- Code & Discount Badge Wrapper -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-4">
                <span class="bg-[#173C32] text-[#C6A15B] px-3 sm:px-4 py-1 text-xs font-bold uppercase tracking-widest">
                    Code: {{ $offer->code }}
                </span>
                <span class="text-base sm:text-lg font-bold text-emerald-800">
                    {{ $offer->discount_type === 'percentage' ? $offer->discount_value . '% OFF' : '$' . number_format($offer->discount_value, 2) . ' OFF' }}
                </span>
            </div>
            <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-forest mb-2">{{ $offer->title }}</h2>
            <p class="text-xs sm:text-sm text-gray-600 mb-6 leading-relaxed">{{ $offer->description }}</p>
        </div>

        <!-- Offer Footer / Min Order & Validity -->
        <div class="text-xs text-gray-500 border-t pt-4 flex flex-col sm:flex-row justify-between gap-1 sm:gap-0">
            <span>Min. Order: ${{ number_format($offer->min_order_amount, 2) }}</span>
            <span>Valid: {{ $offer->start_date->format('M d') }} – {{ $offer->end_date->format('M d, Y') }}</span>
        </div>
    </div>
    @empty
        <div class="col-span-1 md:col-span-2 bg-white p-8 text-center border border-[#173C32]/10 shadow-sm">
            <p class="text-gray-600 text-sm sm:text-base">No active promotional offers at this moment. Please check back soon.</p>
        </div>
    @endforelse
</div>
@endsection