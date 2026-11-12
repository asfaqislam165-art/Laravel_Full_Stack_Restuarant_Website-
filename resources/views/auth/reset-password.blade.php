<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose New Password | The Emerald Oak</title>
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
        <a href="{{ route('login') }}" class="text-xs uppercase tracking-widest text-[#C6A15B] hover:text-white transition font-semibold">
            &larr; Back to Sign In
        </a>
    </header>

    <!-- Main Form Container -->
    <main class="flex-grow flex items-center justify-center p-4 sm:p-6">
        <div class="w-full max-w-md bg-white border-t-4 border-[#C6A15B] shadow-xl p-6 sm:p-8">
            <div class="text-center mb-6">
                <a href="{{ route('home') }}" class="inline-flex w-12 h-12 bg-[#173C32] text-[#C6A15B] items-center justify-center font-serif-luxury font-bold text-xl mb-3 shadow-sm">EO</a>
                <h1 class="font-serif-luxury text-3xl font-bold text-[#173C32]">Create New Password</h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Please enter your new password below.</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-[#173C32] mb-1">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus
                           class="w-full border-gray-300 focus:border-[#C6A15B] focus:ring-[#C6A15B] text-sm px-3 py-2">
                    @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-[#173C32] mb-1">New Password</label>
                    <input id="password" type="password" name="password" required
                           class="w-full border-gray-300 focus:border-[#C6A15B] focus:ring-[#C6A15B] text-sm px-3 py-2">
                    @error('password') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-[#173C32] mb-1">Confirm New Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="w-full border-gray-300 focus:border-[#C6A15B] focus:ring-[#C6A15B] text-sm px-3 py-2">
                </div>

                <button type="submit" class="w-full bg-[#173C32] text-[#C6A15B] hover:bg-[#244D40] py-3.5 text-xs uppercase tracking-widest font-bold transition shadow-sm mt-2">
                    Reset Password
                </button>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-4 text-center text-xs bg-[#112E26] text-gray-300">
        &copy; {{ date('Y') }} The Emerald Oak. All Rights Reserved.
    </footer>

</body>
</html>