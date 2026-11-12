@extends('layouts.app')
@section('title', 'Guest Dashboard')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 py-10 sm:py-16">
    <div class="bg-white border-t-4 border-[#C6A15B] p-6 sm:p-8 md:p-10 shadow-sm">
        <!-- Header & Action Buttons -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b pb-6 mb-6 sm:mb-8">
            <div class="overflow-hidden">
                <span class="text-xs uppercase tracking-widest text-[#C6A15B] font-bold block mb-1">Member Portal</span>
                <h1 class="font-serif-luxury text-3xl sm:text-4xl font-bold text-forest truncate">Welcome, {{ Auth::user()->name }}</h1>
                <p class="text-xs sm:text-sm text-gray-500 truncate mt-0.5">{{ Auth::user()->email }}</p>
            </div>
            <div class="flex flex-wrap items-center gap-2 sm:gap-3 w-full sm:w-auto">
                <a href="{{ route('profile.edit') }}" class="flex-1 sm:flex-none text-center border border-[#173C32] text-[#173C32] px-4 py-2 text-xs uppercase font-bold hover:bg-[#173C32] hover:text-white transition">
                    Edit Profile
                </a>
                <form method="POST" action="{{ route('logout') }}" class="flex-1 sm:flex-none">
                    @csrf
                    <button type="submit" class="w-full sm:w-auto bg-red-800 text-white px-4 py-2 text-xs uppercase font-bold hover:bg-red-900 transition">
                        Sign Out
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Access Action Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('menu') }}" class="bg-ivory p-6 border border-[#173C32]/15 hover:border-[#C6A15B] hover:shadow-md transition">
                <h3 class="font-serif-luxury text-xl sm:text-2xl font-bold text-forest mb-1">Order Fine Dining</h3>
                <p class="text-xs text-gray-600 leading-relaxed">Browse steaks, starters, and desserts for delivery or pickup.</p>
            </a>
            <a href="{{ route('reservation.create') }}" class="bg-ivory p-6 border border-[#173C32]/15 hover:border-[#C6A15B] hover:shadow-md transition">
                <h3 class="font-serif-luxury text-xl sm:text-2xl font-bold text-forest mb-1">Reserve a Table</h3>
                <p class="text-xs text-gray-600 leading-relaxed">Book an evening table in our main dining room.</p>
            </a>
            <a href="{{ route('offers') }}" class="bg-ivory p-6 border border-[#173C32]/15 hover:border-[#C6A15B] hover:shadow-md transition">
                <h3 class="font-serif-luxury text-xl sm:text-2xl font-bold text-forest mb-1">Member Offers</h3>
                <p class="text-xs text-gray-600 leading-relaxed">View active seasonal promo codes and privileges.</p>
            </a>
        </div>
    </div>
</div>
@endsection