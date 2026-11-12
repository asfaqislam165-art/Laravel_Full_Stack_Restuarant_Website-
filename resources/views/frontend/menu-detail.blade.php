@extends('layouts.app')
@section('title', $menuItem->name)

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 sm:py-16">
    <!-- Back Link -->
    <a href="{{ route('menu') }}" class="text-xs uppercase tracking-widest font-bold text-forest hover:text-[#C6A15B] transition">&larr; Back to Full Menu</a>

    <!-- Main Detail Grid -->
    <div class="bg-white border border-[#173C32]/10 mt-6 grid grid-cols-1 md:grid-cols-2 shadow-lg overflow-hidden">
        <!-- Item Image -->
        <div class="h-72 sm:h-96 md:h-auto bg-[#173C32] relative">
            <img src="{{ $menuItem->image ? asset('storage/'.$menuItem->image) : 'https://images.unsplash.com/photo-1600891964092-4316c288032e?auto=format&fit=crop&w=900&q=80' }}"
                 alt="{{ $menuItem->name }}" class="w-full h-full object-cover">
        </div>

        <!-- Details Content -->
        <div class="p-6 sm:p-8 md:p-12 flex flex-col justify-between">
            <div>
                <span class="text-xs uppercase tracking-widest text-[#C6A15B] font-bold">{{ $menuItem->category->name }}</span>
                <h1 class="font-serif-luxury text-2xl sm:text-4xl font-bold text-forest mt-2 mb-2 sm:mb-3">{{ $menuItem->name }}</h1>
                <p class="text-xl sm:text-2xl font-bold text-[#173C32] mb-4 sm:mb-6">${{ number_format($menuItem->price, 2) }}</p>
                <p class="text-gray-700 text-sm sm:text-base leading-relaxed mb-6">{{ $menuItem->description }}</p>

                <div class="text-xs text-gray-500 space-y-1.5 border-t pt-4 mb-6 sm:mb-8">
                    @if($menuItem->prep_time)<p><strong>Preparation Time:</strong> {{ $menuItem->prep_time }}</p>@endif
                    @if($menuItem->dietary_tags)<p><strong>Notes:</strong> {{ $menuItem->dietary_tags }}</p>@endif
                    <p><strong>Availability:</strong> <span class="{{ $menuItem->is_available ? 'text-emerald-700 font-semibold' : 'text-red-700 font-semibold' }}">{{ $menuItem->is_available ? 'Available Today' : 'Sold Out' }}</span></p>
                </div>
            </div>

            @if($menuItem->is_available)
            <form action="{{ route('cart.add', $menuItem) }}" method="POST" class="flex flex-col sm:flex-row gap-3 pt-4 border-t sm:border-t-0 border-gray-100">
                @csrf
                <input type="number" name="quantity" value="1" min="1" max="20" class="w-full sm:w-20 border-gray-300 text-center font-bold py-3 sm:py-2 text-sm">
                <button type="submit" class="flex-1 bg-forest text-[#C6A15B] hover:bg-[#244D40] py-3.5 sm:py-4 text-xs uppercase tracking-widest font-bold transition text-center shadow-sm">
                    Add to Order Cart
                </button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection