@extends('layouts.app')
@section('title', 'Manage Profile')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-16 space-y-10">
    
    <div class="flex justify-between items-center border-b pb-4">
        <div>
            <span class="text-xs uppercase tracking-widest text-[#C6A15B] font-bold">Account Settings</span>
            <h1 class="font-serif-luxury text-4xl font-bold text-forest mt-1">Profile & Password Management</h1>
        </div>
        @if(Auth::user()->usertype === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="text-xs uppercase tracking-widest bg-forest text-[#C6A15B] px-4 py-2 font-bold hover:bg-[#244D40] transition">
                &larr; Back to Admin Dashboard
            </a>
        @else
            <a href="{{ route('dashboard') }}" class="text-xs uppercase tracking-widest bg-forest text-[#C6A15B] px-4 py-2 font-bold hover:bg-[#244D40] transition">
                &larr; Back to Dashboard
            </a>
        @endif
    </div>

    <!-- 1. Update Profile Information Section -->
    <div class="bg-white border-t-4 border-[#C6A15B] p-8 shadow-sm">
        <h2 class="font-serif-luxury text-2xl font-bold text-forest mb-1">Profile Information</h2>
        <p class="text-xs text-gray-500 mb-6">Update your account's profile information and email address.</p>

        @if (session('status') === 'profile-updated')
            <div class="mb-4 text-xs font-semibold text-emerald-800 bg-emerald-50 p-3 border-l-4 border-emerald-700">
                Profile updated successfully.
            </div>
        @endif

        <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('patch')

            <div>
                <label for="name" class="block text-xs font-bold uppercase mb-1">Name</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" class="w-full border-gray-300">
                @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-bold uppercase mb-1">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username" class="w-full border-gray-300">
                @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="bg-forest text-[#C6A15B] hover:bg-[#244D40] px-6 py-3 text-xs uppercase tracking-widest font-bold transition">
                Save Changes
            </button>
        </form>
    </div>

    <!-- 2. Update Password Section -->
    <div class="bg-white border-t-4 border-[#C6A15B] p-8 shadow-sm">
        <h2 class="font-serif-luxury text-2xl font-bold text-forest mb-1">Update Password</h2>
        <p class="text-xs text-gray-500 mb-6">Ensure your account is using a long, random password to stay secure.</p>

        @if (session('status') === 'password-updated')
            <div class="mb-4 text-xs font-semibold text-emerald-800 bg-emerald-50 p-3 border-l-4 border-emerald-700">
                Password updated successfully.
            </div>
        @endif

        <form method="post" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            @method('put')

            <div>
                <label for="current_password" class="block text-xs font-bold uppercase mb-1">Current Password</label>
                <input id="current_password" name="current_password" type="password" autocomplete="current-password" class="w-full border-gray-300">
                @error('current_password', 'updatePassword') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-bold uppercase mb-1">New Password</label>
                <input id="password" name="password" type="password" autocomplete="new-password" class="w-full border-gray-300">
                @error('password', 'updatePassword') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-bold uppercase mb-1">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" class="w-full border-gray-300">
                @error('password_confirmation', 'updatePassword') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="bg-forest text-[#C6A15B] hover:bg-[#244D40] px-6 py-3 text-xs uppercase tracking-widest font-bold transition">
                Update Password
            </button>
        </form>
    </div>

</div>
@endsection