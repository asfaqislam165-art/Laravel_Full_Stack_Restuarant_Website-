<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | The Emerald Oak</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,500&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
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
<body class="bg-[#F7F3EA] text-[#242A26] min-h-screen flex flex-col justify-between">

    <!-- Top Navigation Header -->
    <header class="w-full py-4 px-4 sm:px-6 bg-[#173C32] text-white border-b border-[#C6A15B]/30 flex justify-between items-center shadow-sm">
        <a href="{{ route('home') }}" class="flex items-center space-x-2.5">
            <div class="w-8 h-8 border border-[#C6A15B] flex items-center justify-center text-[#C6A15B] font-serif-luxury text-xl font-bold">EO</div>
            <span class="font-serif-luxury text-lg tracking-wider uppercase">The Emerald Oak</span>
        </a>
        <a href="{{ route('home') }}" class="text-xs uppercase tracking-widest text-[#C6A15B] hover:text-white transition font-semibold">
            &larr; Back to Website
        </a>
    </header>

    <!-- Main Auth Form Container -->
    <main class="flex-grow flex items-center justify-center p-4 sm:p-6">
        <div class="w-full max-w-md bg-white border-t-4 border-[#C6A15B] shadow-xl p-6 sm:p-8">
            <div class="text-center mb-6 sm:mb-8">
                <a href="{{ route('home') }}" class="inline-flex w-12 h-12 bg-[#173C32] text-[#C6A15B] items-center justify-center font-serif-luxury font-bold text-xl mb-3 shadow-sm">EO</a>
                <h1 class="font-serif-luxury text-3xl font-bold text-[#173C32]">Account Sign In</h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Sign in to access your dashboard</p>
            </div>

            @if(session('status'))
                <div class="mb-4 text-xs sm:text-sm text-emerald-700 bg-emerald-50 p-3 border-l-4 border-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-[#173C32] mb-1">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full border-gray-300 focus:border-[#C6A15B] focus:ring-[#C6A15B] text-sm px-3 py-2">
                    @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-[#173C32] mb-1">Password</label>
                    <input id="password" type="password" name="password" required
                           class="w-full border-gray-300 focus:border-[#C6A15B] focus:ring-[#C6A15B] text-sm px-3 py-2">
                    @error('password') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center justify-between text-xs gap-2">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="border-gray-300 text-[#173C32] focus:ring-[#C6A15B] rounded">
                        <span class="ml-2 text-gray-600">Remember me</span>
                    </label>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-[#173C32] hover:text-[#C6A15B] underline shrink-0">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="w-full bg-[#173C32] text-[#C6A15B] hover:bg-[#244D40] py-3.5 text-xs uppercase tracking-widest font-bold transition shadow-sm">
                    Sign In
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-gray-100 text-center text-xs text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-[#173C32] font-bold hover:text-[#C6A15B] underline ml-1">Create Account</a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-4 text-center text-xs bg-[#112E26] text-gray-300">
        &copy; {{ date('Y') }} The Emerald Oak. All Rights Reserved.
    </footer>

</body>
</html>