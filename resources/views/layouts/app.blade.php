<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $siteSettings->restaurant_name ?? 'The Emerald Oak') | Luxury American Dining</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,500&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --forest: #173C32;
            --emerald: #244D40;
            --gold: #C6A15B;
            --ivory: #F7F3EA;
            --white: #FFFFFF;
            --charcoal: #242A26;
        }
        body { background-color: var(--ivory); color: var(--charcoal); font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3, .font-serif-luxury { font-family: 'Cormorant Garamond', serif; }
        .bg-forest { background-color: #173C32; }
        .bg-emerald-dark { background-color: #244D40; }
        .bg-gold { background-color: #C6A15B; }
        .bg-ivory { background-color: #F7F3EA; }
        .text-forest { color: #173C32; }
        .text-gold { color: #C6A15B; }
        .border-gold { border-color: #C6A15B; }
    </style>
</head>
<body class="antialiased flex flex-col min-h-screen">

    <!-- Top Luxury Bar -->
    <div class="bg-emerald-dark text-white text-xs py-2 px-4 sm:px-6 border-b border-[#C6A15B]/30 hidden md:block">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <span class="truncate pr-4">{{ $siteSettings->address ?? '428 Madison Avenue' }}, {{ $siteSettings->city ?? 'New York' }}, {{ $siteSettings->state ?? 'NY' }} {{ $siteSettings->zip_code ?? '10017' }}</span>
            <div class="flex items-center space-x-6 shrink-0">
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings->phone ?? '+12125550194') }}" class="hover:text-[#C6A15B] transition">Call: {{ $siteSettings->phone ?? '+1 (212) 555-0194' }}</a>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings->whatsapp ?? '12125550194') }}" target="_blank" class="text-[#C6A15B] font-semibold hover:underline">WhatsApp Concierge</a>
            </div>
        </div>
    </div>

    <!-- Primary Navigation Bar -->
    <header class="bg-forest text-white sticky top-0 z-50 shadow-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex justify-between items-center">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 shrink-0">
                <div class="w-9 h-9 sm:w-10 sm:h-10 border border-[#C6A15B] flex items-center justify-center text-[#C6A15B] font-serif-luxury text-xl sm:text-2xl font-bold">EO</div>
                <div>
                    <span class="font-serif-luxury text-lg sm:text-2xl tracking-wider uppercase block leading-none truncate max-w-[180px] sm:max-w-none">{{ $siteSettings->restaurant_name ?? 'The Emerald Oak' }}</span>
                    <span class="text-[9px] sm:text-[10px] tracking-[0.25em] text-[#C6A15B] uppercase">Est. New York</span>
                </div>
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden xl:flex items-center space-x-6 text-sm tracking-wide">
                <a href="{{ route('home') }}" class="hover:text-[#C6A15B] transition">Home</a>
                <a href="{{ route('about') }}" class="hover:text-[#C6A15B] transition">About</a>
                <a href="{{ route('menu') }}" class="hover:text-[#C6A15B] transition">Menu</a>
                <a href="{{ route('offers') }}" class="hover:text-[#C6A15B] transition">Offers</a>
                <a href="{{ route('reviews') }}" class="hover:text-[#C6A15B] transition">Reviews</a>
                <a href="{{ route('contact.index') }}" class="hover:text-[#C6A15B] transition">Contact</a>
            </nav>

            <!-- Right Action Buttons -->
            <div class="flex items-center space-x-2 sm:space-x-3">
                <a href="{{ route('reservation.create') }}" class="hidden sm:inline-block border border-[#C6A15B] text-[#C6A15B] hover:bg-[#C6A15B] hover:text-[#173C32] px-3 py-2 text-[11px] sm:text-xs uppercase tracking-widest font-semibold transition">
                    Book Table
                </a>
                
                <a href="{{ route('cart.index') }}" class="relative bg-[#C6A15B] text-[#173C32] hover:bg-white px-3 py-2 text-[11px] sm:text-xs uppercase tracking-widest font-bold transition flex items-center gap-1.5 shadow-sm">
                    <span>Cart</span>
                    <span class="bg-[#173C32] text-white rounded-full px-1.5 py-0.5 text-[10px]">{{ $globalCartCount ?? 0 }}</span>
                </a>

                @auth
                    @if(Auth::user()->usertype === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-[11px] sm:text-xs uppercase tracking-widest text-[#C6A15B] font-bold hover:underline hidden md:inline-block">Admin</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="text-[11px] sm:text-xs uppercase tracking-widest text-[#C6A15B] font-bold hover:underline hidden md:inline-block">Dashboard</a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-[11px] sm:text-xs uppercase tracking-widest text-gray-300 hover:text-white font-medium">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-[11px] sm:text-xs uppercase tracking-widest text-white hover:text-[#C6A15B] font-semibold transition">Sign In</a>
                    <a href="{{ route('register') }}" class="hidden lg:inline-block bg-[#244D40] text-white border border-[#C6A15B] px-3 py-2 text-xs uppercase tracking-widest font-semibold hover:bg-[#C6A15B] hover:text-[#173C32] transition">Register</a>
                @endauth

                <!-- Mobile Menu Toggle Button -->
                <button type="button" onclick="document.getElementById('mobileMenu').classList.toggle('hidden')" class="xl:hidden text-white focus:outline-none p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Dropdown Menu -->
        <div id="mobileMenu" class="hidden xl:hidden bg-[#112E26] border-t border-[#C6A15B]/30 px-6 py-5 space-y-3 shadow-inner">
            <a href="{{ route('home') }}" class="block text-sm py-1 hover:text-[#C6A15B] transition">Home</a>
            <a href="{{ route('about') }}" class="block text-sm py-1 hover:text-[#C6A15B] transition">About Us</a>
            <a href="{{ route('menu') }}" class="block text-sm py-1 hover:text-[#C6A15B] transition">Dinner & Takeout Menu</a>
            <a href="{{ route('offers') }}" class="block text-sm py-1 hover:text-[#C6A15B] transition">Special Offers</a>
            <a href="{{ route('reviews') }}" class="block text-sm py-1 hover:text-[#C6A15B] transition">Guest Reviews</a>
            <a href="{{ route('contact.index') }}" class="block text-sm py-1 hover:text-[#C6A15B] transition">Contact & Location</a>
            <div class="pt-3 border-t border-white/10 flex flex-wrap gap-3">
                <a href="{{ route('reservation.create') }}" class="inline-block border border-[#C6A15B] text-[#C6A15B] px-4 py-2 text-xs uppercase font-semibold">Book Table</a>
                @guest
                    <a href="{{ route('register') }}" class="inline-block bg-[#C6A15B] text-[#173C32] px-4 py-2 text-xs uppercase font-bold">Register</a>
                @endguest
            </div>
        </div>
    </header>

    <!-- Flash Notifications -->
    @if(session('success'))
        <div class="bg-[#244D40] text-white border-l-4 border-[#C6A15B] px-4 sm:px-6 py-3 text-sm max-w-7xl mx-auto mt-4 w-full shadow">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-900 text-white border-l-4 border-[#C6A15B] px-4 sm:px-6 py-3 text-sm max-w-7xl mx-auto mt-4 w-full shadow">
            {{ session('error') }}
        </div>
    @endif

    <!-- Main Content Slot -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Luxury Footer -->
    <footer class="bg-forest text-white border-t border-[#C6A15B]/30 mt-16 sm:mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12 sm:py-16 grid grid-cols-1 md:grid-cols-4 gap-8 sm:gap-12">
            <div>
                <h3 class="font-serif-luxury text-xl sm:text-2xl text-[#C6A15B] mb-3">{{ $siteSettings->restaurant_name ?? 'The Emerald Oak' }}</h3>
                <p class="text-xs sm:text-sm text-gray-300 leading-relaxed">{{ $siteSettings->tagline ?? 'Modern American Steakhouse & Fine Dining' }}. Wood-fired prime steaks, coastal raw bar, and timeless American hospitality.</p>
            </div>
            <div>
                <h4 class="text-xs uppercase tracking-widest text-[#C6A15B] font-bold mb-3 sm:mb-4">Navigation</h4>
                <ul class="space-y-2 text-xs sm:text-sm text-gray-300">
                    <li><a href="{{ route('menu') }}" class="hover:text-[#C6A15B] transition">Dinner & Takeout Menu</a></li>
                    <li><a href="{{ route('reservation.create') }}" class="hover:text-[#C6A15B] transition">Reserve a Table</a></li>
                    <li><a href="{{ route('offers') }}" class="hover:text-[#C6A15B] transition">Seasonal Privileges</a></li>
                    <li><a href="{{ route('reviews') }}" class="hover:text-[#C6A15B] transition">Press & Guest Reviews</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-xs uppercase tracking-widest text-[#C6A15B] font-bold mb-3 sm:mb-4">Opening Hours</h4>
                <p class="text-xs sm:text-sm text-gray-300 whitespace-pre-line leading-relaxed">{{ $siteSettings->opening_hours ?? "Mon–Thu: 11:30 AM – 10:30 PM\nFri–Sat: 11:30 AM – 11:30 PM\nSunday: 12:00 PM – 9:30 PM" }}</p>
            </div>
            <div>
                <h4 class="text-xs uppercase tracking-widest text-[#C6A15B] font-bold mb-3 sm:mb-4">Visit & Order</h4>
                <p class="text-xs sm:text-sm text-gray-300 mb-2">{{ $siteSettings->address ?? '428 Madison Avenue' }}, {{ $siteSettings->city ?? 'New York' }}, {{ $siteSettings->state ?? 'NY' }} {{ $siteSettings->zip_code ?? '10017' }}</p>
                <p class="text-xs sm:text-sm text-[#C6A15B] font-semibold mb-4">{{ $siteSettings->phone ?? '+1 (212) 555-0194' }}</p>
                @auth
                    @if(Auth::user()->usertype === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-xs text-[#C6A15B] hover:text-white underline font-semibold">Admin Dashboard &rarr;</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="text-xs text-[#C6A15B] hover:text-white underline font-semibold">My Account Dashboard &rarr;</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-xs text-gray-400 hover:text-white underline transition">Staff & Admin Portal</a>
                @endauth
            </div>
        </div>
        <div class="bg-[#112E26] py-4 text-center text-xs text-gray-400 px-4">
            &copy; {{ date('Y') }} {{ $siteSettings->restaurant_name ?? 'The Emerald Oak' }}. All Rights Reserved.
        </div>
    </footer>
</body>
</html>