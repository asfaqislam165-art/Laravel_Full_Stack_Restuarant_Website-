@extends('layouts.app')
@section('title', 'Contact Us')

@section('content')
<!-- Hero Section -->
<section class="bg-forest text-white py-12 sm:py-16 text-center px-4 sm:px-6">
    <span class="text-[#C6A15B] uppercase tracking-[0.2em] sm:tracking-[0.3em] text-xs font-bold">Get in Touch</span>
    <h1 class="font-serif-luxury text-3xl sm:text-4xl md:text-5xl font-bold mt-2 px-2">Contact & Location</h1>
</section>

<!-- Main Container -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-10 sm:py-16 grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
    <!-- Contact Form Section -->
    <div class="bg-white p-6 sm:p-8 border border-[#173C32]/10 shadow-sm">
        <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-forest mb-6">Send a Message</h2>
        <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold uppercase mb-1">Your Name *</label>
                <input type="text" name="name" required class="w-full border-gray-300 px-3 py-2 text-sm">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase mb-1">Email *</label>
                    <input type="email" name="email" required class="w-full border-gray-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase mb-1">Phone</label>
                    <input type="tel" name="phone" class="w-full border-gray-300 px-3 py-2 text-sm">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold uppercase mb-1">Subject *</label>
                <input type="text" name="subject" required class="w-full border-gray-300 px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase mb-1">Message *</label>
                <textarea name="message" rows="4" required class="w-full border-gray-300 px-3 py-2 text-sm"></textarea>
            </div>
            <button type="submit" class="w-full sm:w-auto bg-forest text-[#C6A15B] px-8 py-3 text-xs uppercase tracking-widest font-bold hover:bg-[#244D40] transition text-center">
                Send Inquiry
            </button>
        </form>
    </div>

    <!-- Details & Map Section -->
    <div class="space-y-6">
        <div class="bg-white p-6 sm:p-8 border border-[#173C32]/10 space-y-3 text-sm shadow-sm">
            <h2 class="font-serif-luxury text-2xl sm:text-3xl font-bold text-forest mb-2">Restaurant Details</h2>
            <p class="break-words"><strong>Address:</strong> {{ $siteSettings->address }}, {{ $siteSettings->city }}, {{ $siteSettings->state }} {{ $siteSettings->zip_code }}</p>
            <p><strong>Phone:</strong> <a href="tel:{{ $siteSettings->phone }}" class="text-forest underline">{{ $siteSettings->phone }}</a></p>
            <p><strong>WhatsApp:</strong> <a href="https://wa.me/{{ $siteSettings->whatsapp }}" target="_blank" class="text-emerald-700 underline">Chat on WhatsApp</a></p>
            <p class="break-all"><strong>Email:</strong> {{ $siteSettings->email }}</p>
            <div class="pt-2">
                <strong class="block mb-1">Hours:</strong>
                <p class="whitespace-pre-line text-gray-600 text-xs sm:text-sm">{{ $siteSettings->opening_hours }}</p>
            </div>
        </div>

        @if($siteSettings->google_maps_embed)
        <div class="h-64 sm:h-72 border border-[#173C32]/20 shadow-sm">
            <iframe src="{{ $siteSettings->google_maps_embed }}" class="w-full h-full border-0" loading="lazy"></iframe>
        </div>
        @endif
    </div>
</div>
@endsection