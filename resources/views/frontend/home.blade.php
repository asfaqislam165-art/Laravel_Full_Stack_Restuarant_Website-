@extends('layouts.app')
@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<section class="relative bg-forest text-white overflow-hidden">
    <div class="absolute inset-0 opacity-35 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=1920&q=80');"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 py-20 sm:py-28 md:py-36">
        <span class="text-[#C6A15B] uppercase tracking-[0.2em] sm:tracking-[0.3em] text-xs font-bold block mb-3 sm:mb-4">Prime Wood-Fired American Dining</span>
        <h1 class="font-serif-luxury text-3xl sm:text-5xl md:text-7xl font-bold max-w-3xl leading-tight mb-6">
            An Unrivaled Tradition of Fire, Craft & Hospitality.
        </h1>
        <p class="text-gray-200 max-w-xl text-base sm:text-lg mb-8 sm:mb-10 leading-relaxed">
            Dry-aged USDA Prime cuts seared over white oak embers, paired with seasonal coastal harvests—available in our dining room or delivered straight to your door.
        </p>
        <div class="flex flex-col sm:flex-row flex-wrap gap-4">
            <a href="{{ route('menu') }}" class="bg-[#C6A15B] text-[#173C32] hover:bg-white px-8 py-4 text-xs uppercase tracking-widest font-bold transition text-center">
                Order Online Now
            </a>
            <a href="{{ route('reservation.create') }}" class="border border-white text-white hover:border-[#C6A15B] hover:text-[#C6A15B] px-8 py-4 text-xs uppercase tracking-widest font-bold transition text-center">
                Reserve Your Table
            </a>
        </div>
    </div>
</section>

<!-- Restaurant Introduction -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 py-12 sm:py-20 grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-14 items-center">
    <div>
        <span class="text-[#C6A15B] uppercase tracking-[0.25em] text-xs font-bold">Our Heritage</span>
        <h2 class="font-serif-luxury text-3xl sm:text-4xl md:text-5xl text-forest font-bold mt-2 mb-4 sm:mb-6">Classic American Elegance, Reimagined.</h2>
        <p class="text-[#242A26]/80 text-sm sm:text-base leading-relaxed mb-6">
            At {{ $siteSettings->restaurant_name }}, every cut is hand-selected from family-owned American ranches and dry-aged in-house for up to 45 days. Whether you are celebrating an evening in our Midtown dining room or ordering a private dinner at home, every dish reflects uncompromising culinary discipline.
        </p>
        <div class="grid grid-cols-3 gap-4 sm:gap-6 border-t border-[#173C32]/15 pt-6 text-center sm:text-left">
            <div>
                <span class="font-serif-luxury text-2xl sm:text-3xl font-bold text-forest">45 Days</span>
                <p class="text-[10px] sm:text-xs text-gray-600 uppercase tracking-wider mt-1">In-House Dry Aging</p>
            </div>
            <div>
                <span class="font-serif-luxury text-2xl sm:text-3xl font-bold text-forest">100%</span>
                <p class="text-[10px] sm:text-xs text-gray-600 uppercase tracking-wider mt-1">USDA Prime Cuts</p>
            </div>
            <div>
                <span class="font-serif-luxury text-2xl sm:text-3xl font-bold text-forest">1,200°F</span>
                <p class="text-[10px] sm:text-xs text-gray-600 uppercase tracking-wider mt-1">White Oak Hearth</p>
            </div>
        </div>
    </div>
    <div class="relative w-full">
        <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?auto=format&fit=crop&w=1000&q=80" alt="Fine Dining Steakhouse" class="w-full h-auto shadow-2xl border-2 sm:border-4 border-white object-cover">
    </div>
</section>

<!-- Featured Menu Items -->
<section class="bg-white py-14 sm:py-20 border-y border-[#173C32]/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-14">
            <span class="text-[#C6A15B] uppercase tracking-[0.25em] text-xs font-bold">Chef's Selection</span>
            <h2 class="font-serif-luxury text-3xl sm:text-4xl md:text-5xl text-forest font-bold mt-2">Signature Creations</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
            @foreach($featuredItems as $item)
            <div class="bg-ivory border border-[#173C32]/10 flex flex-col justify-between group hover:shadow-xl transition duration-300">
                <div>
                    <div class="h-60 overflow-hidden bg-[#173C32] relative">
                        <img src="{{ $item->image ? asset('storage/'.$item->image) : 'https://images.unsplash.com/photo-1600891964092-4316c288032e?auto=format&fit=crop&w=800&q=80' }}"
                             alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @if($item->dietary_tags)
                            <span class="absolute top-3 left-3 bg-[#173C32] text-[#C6A15B] text-[10px] uppercase tracking-widest px-3 py-1 font-semibold">
                                {{ $item->dietary_tags }}
                            </span>
                        @endif
                    </div>
                    <div class="p-5 sm:p-6">
                        <div class="flex justify-between items-start gap-4 mb-2">
                            <a href="{{ route('menu.show', $item->slug) }}" class="font-serif-luxury text-xl sm:text-2xl font-bold text-forest hover:text-[#C6A15B] transition">
                                {{ $item->name }}
                            </a>
                            <span class="font-bold text-base sm:text-lg text-[#173C32] shrink-0">${{ number_format($item->price, 2) }}</span>
                        </div>
                        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">{{ $item->description }}</p>
                    </div>
                </div>
                <div class="px-5 sm:px-6 pb-5 sm:pb-6">
                    <form action="{{ route('cart.add', $item) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-forest text-white hover:bg-[#C6A15B] hover:text-[#173C32] py-3 text-xs uppercase tracking-widest font-bold transition">
                            Add to Order
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Active Special Offers Banner -->
@if($offers->count())
<section class="bg-forest text-white py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 sm:mb-10 gap-2">
            <div>
                <span class="text-[#C6A15B] uppercase tracking-widest text-xs font-bold">Limited-Time Privileges</span>
                <h2 class="font-serif-luxury text-3xl sm:text-4xl font-bold mt-1">Seasonal Dining Offers</h2>
            </div>
            <a href="{{ route('offers') }}" class="text-[#C6A15B] text-xs uppercase tracking-widest underline hover:text-white transition">View All Offers</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($offers as $offer)
            <div class="bg-emerald-dark border border-[#C6A15B]/40 p-6 shadow-sm">
                <span class="inline-block bg-[#C6A15B] text-[#173C32] text-xs font-bold px-3 py-1 uppercase tracking-wider mb-3">
                    Code: {{ $offer->code }}
                </span>
                <h3 class="font-serif-luxury text-xl sm:text-2xl font-bold mb-2">{{ $offer->title }}</h3>
                <p class="text-xs sm:text-sm text-gray-200 mb-4">{{ $offer->description }}</p>
                <p class="text-xs text-[#C6A15B]">Valid through {{ $offer->end_date->format('M d, Y') }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Curated Guest Reviews -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 py-12 sm:py-20">
    <div class="text-center mb-10 sm:mb-12">
        <span class="text-[#C6A15B] uppercase tracking-[0.25em] text-xs font-bold">Acclaim</span>
        <h2 class="font-serif-luxury text-3xl sm:text-4xl text-forest font-bold mt-2">What Our Guests Say</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
        @foreach($reviews as $review)
        <div class="bg-white p-6 sm:p-8 border border-[#173C32]/10 shadow-sm">
            <div class="text-[#C6A15B] text-lg mb-3">
                {{ str_repeat('★', $review->rating) }}
            </div>
            <p class="font-serif-luxury italic text-lg sm:text-xl text-forest mb-5">"{{ $review->review_text }}"</p>
            <div>
                <p class="font-bold text-sm text-[#242A26]">{{ $review->reviewer_name }}</p>
                @if($review->reviewer_title)
                    <p class="text-xs text-gray-500">{{ $review->reviewer_title }}</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection