<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | {{ $siteSettings->restaurant_name ?? 'The Emerald Oak' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F7F3EA] text-[#242A26] min-h-screen flex">

    <!-- Mobile Sidebar Toggle Checkbox -->
    <input type="checkbox" id="sidebar-toggle" class="peer sr-only" />

    <!-- Mobile Backdrop -->
    <label for="sidebar-toggle" aria-hidden="true" class="fixed inset-0 z-30 hidden bg-black/60 peer-checked:block lg:hidden"></label>

    <!-- Responsive Luxury Sidebar -->
    <aside id="dashboard-sidebar" class="fixed inset-y-0 start-0 z-40 flex w-64 -translate-x-full flex-col justify-between overflow-y-auto bg-[#173C32] text-white transition-transform duration-300 peer-checked:translate-x-0 lg:static lg:shrink-0 lg:translate-x-0">
        <div>
            <!-- Brand Header -->
            <div class="p-6 border-b border-[#C6A15B]/30">
                <span class="text-[#C6A15B] text-[10px] uppercase tracking-[0.25em] font-bold block">Admin Console</span>
                <h2 class="text-xl font-bold mt-1 tracking-wide truncate">{{ $siteSettings->restaurant_name ?? 'The Emerald Oak' }}</h2>
            </div>

            <!-- Navigation Links -->
            <nav aria-label="Dashboard" class="p-4 space-y-1 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="block rounded-lg px-4 py-2.5 font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#244D40] text-[#C6A15B] font-bold' : 'text-gray-200 hover:bg-[#244D40] hover:text-white' }}">
                    Dashboard Overview
                </a>
                <a href="{{ route('admin.orders.index') }}" class="block rounded-lg px-4 py-2.5 font-medium transition {{ request()->routeIs('admin.orders.*') ? 'bg-[#244D40] text-[#C6A15B] font-bold' : 'text-gray-200 hover:bg-[#244D40] hover:text-white' }}">
                    Orders Management
                </a>
                <a href="{{ route('admin.manual-orders.create') }}" class="block rounded-lg px-4 py-2.5 font-semibold text-[#C6A15B] transition hover:bg-[#244D40]">
                    + Manual Phone Order
                </a>
                <a href="{{ route('admin.categories.index') }}" class="block rounded-lg px-4 py-2.5 font-medium transition {{ request()->routeIs('admin.categories.*') ? 'bg-[#244D40] text-[#C6A15B] font-bold' : 'text-gray-200 hover:bg-[#244D40] hover:text-white' }}">
                    Categories
                </a>
                <a href="{{ route('admin.menu-items.index') }}" class="block rounded-lg px-4 py-2.5 font-medium transition {{ request()->routeIs('admin.menu-items.*') ? 'bg-[#244D40] text-[#C6A15B] font-bold' : 'text-gray-200 hover:bg-[#244D40] hover:text-white' }}">
                    Menu Items
                </a>
                <a href="{{ route('admin.reservations.index') }}" class="block rounded-lg px-4 py-2.5 font-medium transition {{ request()->routeIs('admin.reservations.*') ? 'bg-[#244D40] text-[#C6A15B] font-bold' : 'text-gray-200 hover:bg-[#244D40] hover:text-white' }}">
                    Reservations
                </a>
                <a href="{{ route('admin.offers.index') }}" class="block rounded-lg px-4 py-2.5 font-medium transition {{ request()->routeIs('admin.offers.*') ? 'bg-[#244D40] text-[#C6A15B] font-bold' : 'text-gray-200 hover:bg-[#244D40] hover:text-white' }}">
                    Special Offers
                </a>
                <a href="{{ route('admin.reviews.index') }}" class="block rounded-lg px-4 py-2.5 font-medium transition {{ request()->routeIs('admin.reviews.*') ? 'bg-[#244D40] text-[#C6A15B] font-bold' : 'text-gray-200 hover:bg-[#244D40] hover:text-white' }}">
                    Reviews (Admin Only)
                </a>
                <a href="{{ route('admin.messages.index') }}" class="block rounded-lg px-4 py-2.5 font-medium transition {{ request()->routeIs('admin.messages.*') ? 'bg-[#244D40] text-[#C6A15B] font-bold' : 'text-gray-200 hover:bg-[#244D40] hover:text-white' }}">
                    Contact Messages
                </a>
                <a href="{{ route('admin.settings.edit') }}" class="block rounded-lg px-4 py-2.5 font-medium transition {{ request()->routeIs('admin.settings.*') ? 'bg-[#244D40] text-[#C6A15B] font-bold' : 'text-gray-200 hover:bg-[#244D40] hover:text-white' }}">
                    Restaurant Settings
                </a>
            </nav>
        </div>

        <!-- Bottom Admin Profile & Logout Section -->
        <div class="sticky inset-x-0 bottom-0 border-t border-[#C6A15B]/30 bg-[#112E26]">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 p-4 hover:bg-[#244D40] transition">
                <div class="w-10 h-10 rounded-full bg-[#C6A15B] text-[#173C32] flex items-center justify-center font-bold text-sm uppercase shrink-0">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
                <div class="text-xs overflow-hidden">
                    <strong class="block font-semibold text-white truncate">{{ Auth::user()->name }}</strong>
                    <span class="text-gray-300 truncate block">{{ Auth::user()->email }}</span>
                </div>
            </a>
            <div class="px-4 pb-4 flex justify-between items-center text-xs border-t border-white/10 pt-3">
                <a href="{{ route('home') }}" target="_blank" class="text-[#C6A15B] hover:underline font-semibold">Live Site &rarr;</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-300 hover:text-white font-semibold uppercase tracking-wider">Sign Out</button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Right Wrapper -->
    <div class="flex flex-1 flex-col overflow-y-auto">
        <!-- Top Header -->
        <header class="flex items-center justify-between border-b border-[#173C32]/15 bg-white px-4 sm:px-6 py-4 shadow-sm">
            <div class="flex items-center gap-3">
                <label for="sidebar-toggle" id="sidebar-toggle-label" aria-expanded="false" aria-controls="dashboard-sidebar" class="cursor-pointer rounded-md p-2 text-[#173C32] hover:bg-gray-100 lg:hidden">
                    <span class="sr-only">Toggle menu</span>
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </label>
                <h1 class="text-base sm:text-lg font-bold text-[#173C32]">Restaurant Management Portal</h1>
            </div>

            <a href="{{ route('admin.manual-orders.create') }}" class="hidden sm:inline-block bg-[#173C32] text-[#C6A15B] hover:bg-[#244D40] px-4 py-2 text-xs uppercase tracking-widest font-bold transition">
                + New Phone Order
            </a>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-4 sm:p-6 space-y-6">
            @if(session('success'))
                <div class="bg-[#244D40] text-white border-l-4 border-[#C6A15B] px-5 py-3 shadow text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-900 text-white border-l-4 border-[#C6A15B] px-5 py-3 shadow text-sm">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        const sidebarToggleCheckbox = document.getElementById('sidebar-toggle');
        const sidebarToggleLabel = document.getElementById('sidebar-toggle-label');
        if (sidebarToggleCheckbox && sidebarToggleLabel) {
            sidebarToggleCheckbox.addEventListener('change', () => {
                sidebarToggleLabel.setAttribute('aria-expanded', String(sidebarToggleCheckbox.checked));
            });
        }
    </script>
</body>
</html>