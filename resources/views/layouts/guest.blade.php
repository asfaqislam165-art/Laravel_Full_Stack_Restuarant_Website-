<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'The Emerald Oak') }} | Authentication</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,500&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            :root {
                --forest: #173C32;
                --emerald: #244D40;
                --gold: #C6A15B;
                --ivory: #F7F3EA;
                --charcoal: #242A26;
            }
            body { background-color: var(--ivory); color: var(--charcoal); font-family: 'Plus Jakarta Sans', sans-serif; }
            h1, h2, h3, .font-serif-luxury { font-family: 'Cormorant Garamond', serif; }
        </style>
    </head>
    <body class="antialiased min-h-screen flex flex-col justify-between">

        <!-- Top Header / Back to Home Link -->
        <header class="w-full py-4 px-4 sm:px-6 bg-forest text-white border-b border-[#C6A15B]/30 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center space-x-2.5">
                <div class="w-8 h-8 border border-[#C6A15B] flex items-center justify-center text-[#C6A15B] font-serif-luxury text-xl font-bold">EO</div>
                <span class="font-serif-luxury text-lg tracking-wider uppercase">The Emerald Oak</span>
            </a>
            <a href="{{ route('home') }}" class="text-xs uppercase tracking-widest text-[#C6A15B] hover:text-white transition font-semibold">
                &larr; Back to Website
            </a>
        </header>

        <!-- Main Auth Container -->
        <main class="flex-grow flex flex-col justify-center items-center px-4 sm:px-6 py-12">
            <div class="w-full sm:max-w-md bg-white p-6 sm:p-8 border border-[#173C32]/10 shadow-xl rounded-none sm:rounded-lg">
                {{ $slot }}
            </div>
        </main>

        <!-- Footer -->
        <footer class="py-4 text-center text-xs  bg-[#112E26] text-gray-300">
            &copy; {{ date('Y') }} The Emerald Oak. All Rights Reserved.
        </footer>
    </body>
</html>