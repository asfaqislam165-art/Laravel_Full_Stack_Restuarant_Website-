@extends('layouts.app')
@section('title', 'Our Menu')

@section('content')
<!-- Hero & Search Section -->
<section class="bg-forest text-white py-12 sm:py-16 px-4 sm:px-6 text-center">
    <span class="text-[#C6A15B] uppercase tracking-[0.2em] sm:tracking-[0.3em] text-xs font-bold">Wood-Fired & Handcrafted</span>
    <h1 class="font-serif-luxury text-3xl sm:text-4xl md:text-5xl font-bold mt-2 mb-6 px-2">Dinner & Takeout Menu</h1>

    <form action="{{ route('menu') }}" method="GET" class="max-w-lg mx-auto flex flex-col sm:flex-row gap-2 px-2 sm:px-0">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search steaks, seafood, burgers..."
               class="w-full text-[#242A26] border-0 px-4 py-3 text-sm rounded sm:rounded-none">
        <button type="submit" class="bg-[#C6A15B] text-[#173C32] px-6 py-3 text-xs uppercase font-bold tracking-widest hover:bg-white transition shrink-0">
            Search
        </button>
    </form>
</section>

<!-- Menu Categories & Items Container -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-10 sm:py-16 space-y-12 sm:space-y-16">
    @foreach($categories as $category)
        @if($category->menuItems->count())
        <div>
            <!-- Category Title & Description -->
            <div class="border-b-2 border-[#C6A15B] pb-3 mb-6 sm:mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-2">
                <div>
                    <h2 class="font-serif-luxury text-2xl sm:text-3xl md:text-4xl font-bold text-forest">{{ $category->name }}</h2>
                    @if($category->description)
                        <p class="text-xs sm:text-sm text-gray-600 mt-1">{{ $category->description }}</p>
                    @endif
                </div>
            </div>

            <!-- Items Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach($category->menuItems as $item)
                <div class="bg-white border border-[#173C32]/10 flex flex-col justify-between shadow-sm hover:shadow-lg transition">
                    <div>
                        <!-- Item Image & Sold Out Overlay -->
                        <div class="h-56 bg-[#173C32] relative overflow-hidden">
                            <img src="{{ $item->image ? asset('storage/'.$item->image) : 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=800&q=80' }}"
                                 alt="{{ $item->name }}" class="w-full h-full object-cover">
                            @if(!$item->is_available)
                                <div class="absolute inset-0 bg-black/70 flex items-center justify-center">
                                    <span class="bg-red-800 text-white text-xs uppercase tracking-widest px-4 py-1 font-bold">Sold Out</span>
                                </div>
                            @endif
                        </div>

                        <!-- Item Content -->
                        <div class="p-5 sm:p-6">
                            <div class="flex justify-between items-start gap-3 mb-2">
                                <a href="{{ route('menu.show', $item->slug) }}" class="font-serif-luxury text-xl sm:text-2xl font-bold text-forest hover:text-[#C6A15B] transition">
                                    {{ $item->name }}
                                </a>
                                <span class="font-bold text-base sm:text-lg text-[#173C32] shrink-0">${{ number_format($item->price, 2) }}</span>
                            </div>
                            <p class="text-xs sm:text-sm text-gray-600 mb-3 leading-relaxed">{{ $item->description }}</p>
                            @if($item->prep_time)
                                <span class="text-xs text-gray-400 block">Prep time: {{ $item->prep_time }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Cart Actions / Quantity Form -->
                    <div class="px-5 sm:px-6 pb-5 sm:pb-6">
                        @if($item->is_available)
                            <form action="{{ route('cart.add', $item) }}" method="POST" class="flex gap-2">
                                @csrf
                                <input type="number" name="quantity" value="1" min="1" max="20" class="w-16 border-gray-300 text-center text-sm py-2">
                                <button type="submit" class="flex-1 bg-forest text-white hover:bg-[#C6A15B] hover:text-[#173C32] py-3 text-xs uppercase tracking-widest font-bold transition">
                                    Add to Cart
                                </button>
                            </form>
                        @else
                            <button disabled class="w-full bg-gray-300 text-gray-600 py-3 text-xs uppercase tracking-widest font-bold cursor-not-allowed">
                                Currently Unavailable
                            </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    @endforeach
</div>
@endsection