@extends('layouts.app')
@section('title', 'About Us')

@section('content')
<!-- Hero Section -->
<section class="bg-forest text-white py-14 sm:py-20 text-center px-4 sm:px-6">
    <span class="text-[#C6A15B] uppercase tracking-[0.2em] sm:tracking-[0.3em] text-xs font-bold">Our Story</span>
    <h1 class="font-serif-luxury text-3xl sm:text-5xl md:text-6xl font-bold mt-3 px-2">A Legacy of American Fine Dining</h1>
</section>

<!-- Main Story Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 py-12 sm:py-20 grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-14 items-center">
    <!-- Image with responsive aspect/sizing fix -->
    <div class="w-full">
        <img src="https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?auto=format&fit=crop&w=1000&q=80" alt="Restaurant Interior" class="w-full h-auto shadow-xl border-2 sm:border-4 border-white object-cover">
    </div>
    
    <!-- Text Content -->
    <div class="text-center lg:text-left">
        <h2 class="font-serif-luxury text-3xl sm:text-4xl text-forest font-bold mb-4">Rooted in Craft & Fire</h2>
        <p class="text-gray-700 leading-relaxed text-sm sm:text-base mb-4">
            Founded in New York City, {{ $siteSettings->restaurant_name }} celebrates the golden era of classic American steakhouses. We partner exclusively with heritage Midwest family farms for USDA Prime beef and Atlantic day-boat fishermen for wild seafood.
        </p>
        <h3 class="font-serif-luxury text-xl sm:text-2xl text-forest font-bold mt-6 mb-2">Our Mission</h3>
        <p class="text-gray-700 leading-relaxed text-sm sm:text-base mb-6">
            To deliver an unforgettable culinary sanctuary defined by warm hospitality, live white-oak grilling, and uncompromising ingredient integrity—whether enjoyed in our velvet booths or at your family dining table.
        </p>
        <div class="flex justify-center lg:justify-start">
            <a href="{{ route('reservation.create') }}" class="inline-block bg-forest text-[#C6A15B] px-6 sm:px-8 py-3 text-xs uppercase tracking-widest font-bold hover:bg-[#244D40] transition w-full sm:w-auto text-center">
                Reserve an Experience
            </a>
        </div>
    </div>
</section>

<!-- Culinary Leadership -->
<section class="bg-white py-14 sm:py-20 border-t border-[#173C32]/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-10 sm:mb-14">
            <span class="text-[#C6A15B] uppercase tracking-widest text-xs font-bold">Culinary Leadership</span>
            <h2 class="font-serif-luxury text-3xl sm:text-4xl text-forest font-bold mt-2">Meet Our Chefs</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8 text-center">
            <div class="bg-ivory p-6 sm:p-8 border border-[#173C32]/10 transition hover:shadow-md">
                <h3 class="font-serif-luxury text-xl sm:text-2xl font-bold text-forest">Chef Harrison Cole</h3>
                <p class="text-xs uppercase tracking-widest text-[#C6A15B] font-bold mb-3 mt-1">Executive Chef</p>
                <p class="text-xs sm:text-sm text-gray-600">20 years leading premier Manhattan steakhouses and wood-fire kitchens.</p>
            </div>
            <div class="bg-ivory p-6 sm:p-8 border border-[#173C32]/10 transition hover:shadow-md">
                <h3 class="font-serif-luxury text-xl sm:text-2xl font-bold text-forest">Chef Elena Rostova</h3>
                <p class="text-xs uppercase tracking-widest text-[#C6A15B] font-bold mb-3 mt-1">Chef de Cuisine</p>
                <p class="text-xs sm:text-sm text-gray-600">Specialist in dry-aging programs, artisanal sauces, and coastal raw bar.</p>
            </div>
            <div class="bg-ivory p-6 sm:p-8 border border-[#173C32]/10 transition hover:shadow-md">
                <h3 class="font-serif-luxury text-xl sm:text-2xl font-bold text-forest">Chef Marcus Sterling</h3>
                <p class="text-xs uppercase tracking-widest text-[#C6A15B] font-bold mb-3 mt-1">Executive Pastry Chef</p>
                <p class="text-xs sm:text-sm text-gray-600">Creator of our signature Kentucky Bourbon Pecan Pie and velvet cheesecakes.</p>
            </div>
        </div>
    </div>
</section>
@endsection