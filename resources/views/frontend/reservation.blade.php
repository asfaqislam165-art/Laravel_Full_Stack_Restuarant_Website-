@extends('layouts.app')
@section('title', 'Table Reservation')

@section('content')
<!-- Hero Section -->
<section class="bg-forest text-white py-12 sm:py-16 text-center px-4 sm:px-6">
    <span class="text-[#C6A15B] uppercase tracking-[0.2em] sm:tracking-[0.3em] text-xs font-bold">Concierge Booking</span>
    <h1 class="font-serif-luxury text-3xl sm:text-4xl md:text-5xl font-bold mt-2 px-2">Reserve a Table</h1>
</section>

<!-- Reservation Form Container -->
<div class="max-w-3xl mx-auto px-4 sm:px-6 py-10 sm:py-16">
    <form action="{{ route('reservation.store') }}" method="POST" class="bg-white border-t-4 border-[#C6A15B] p-6 sm:p-8 md:p-10 shadow-lg space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            <div>
                <label class="block text-xs font-bold uppercase mb-1">Full Name *</label>
                <input type="text" name="customer_name" value="{{ old('customer_name') }}" required class="w-full border-gray-300 px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase mb-1">Phone Number *</label>
                <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="(212) 555-0199" required class="w-full border-gray-300 px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase mb-1">Email Address *</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full border-gray-300 px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase mb-1">Number of Guests *</label>
                <select name="guests" class="w-full border-gray-300 px-3 py-2 text-sm">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ old('guests') == $i ? 'selected' : '' }}>{{ $i }} {{ $i === 1 ? 'Guest' : 'Guests' }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold uppercase mb-1">Reservation Date *</label>
                <input type="date" name="reservation_date" value="{{ old('reservation_date') }}" min="{{ date('Y-m-d') }}" required class="w-full border-gray-300 px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase mb-1">Preferred Time *</label>
                <input type="time" name="reservation_time" value="{{ old('reservation_time', '19:30') }}" required class="w-full border-gray-300 px-3 py-2 text-sm">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold uppercase mb-1">Special Requests (Anniversary, Booth, Dietary)</label>
            <textarea name="special_requests" rows="3" placeholder="Let us know if you have any special preferences..." class="w-full border-gray-300 px-3 py-2 text-sm">{{ old('special_requests') }}</textarea>
        </div>

        <button type="submit" class="w-full bg-forest text-[#C6A15B] hover:bg-[#244D40] py-3.5 sm:py-4 text-xs uppercase tracking-widest font-bold transition shadow-sm">
            Confirm Reservation Request
        </button>
    </form>
</div>
@endsection