<!-- resources/views/admin/settings/edit.blade.php -->
@extends('layouts.admin')
@section('content')
<h1 class="text-3xl font-bold text-[#173C32] mb-6">Restaurant Settings</h1>
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 shadow-sm max-w-4xl space-y-6">
    @csrf @method('PUT')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Restaurant Name *</label>
            <input type="text" name="restaurant_name" value="{{ $settings->restaurant_name }}" required class="w-full border-gray-300">
        </div>
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Tagline</label>
            <input type="text" name="tagline" value="{{ $settings->tagline }}" class="w-full border-gray-300">
        </div>
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Phone Number *</label>
            <input type="text" name="phone" value="{{ $settings->phone }}" required class="w-full border-gray-300">
        </div>
        <div>
            <label class="block text-xs font-bold uppercase mb-1">WhatsApp Number (Digits with Country Code) *</label>
            <input type="text" name="whatsapp" value="{{ $settings->whatsapp }}" required class="w-full border-gray-300">
        </div>
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Email *</label>
            <input type="email" name="email" value="{{ $settings->email }}" required class="w-full border-gray-300">
        </div>
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Street Address *</label>
            <input type="text" name="address" value="{{ $settings->address }}" required class="w-full border-gray-300">
        </div>
        <div>
            <label class="block text-xs font-bold uppercase mb-1">City *</label>
            <input type="text" name="city" value="{{ $settings->city }}" required class="w-full border-gray-300">
        </div>
        <div class="grid grid-cols-2 gap-2">
            <div>
                <label class="block text-xs font-bold uppercase mb-1">State *</label>
                <input type="text" name="state" value="{{ $settings->state }}" required class="w-full border-gray-300">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase mb-1">ZIP Code *</label>
                <input type="text" name="zip_code" value="{{ $settings->zip_code }}" required class="w-full border-gray-300">
            </div>
        </div>
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Delivery Fee ($) *</label>
            <input type="number" step="0.01" name="delivery_fee" value="{{ $settings->delivery_fee }}" required class="w-full border-gray-300">
        </div>
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Minimum Order Amount ($) *</label>
            <input type="number" step="0.01" name="minimum_order_amount" value="{{ $settings->minimum_order_amount }}" required class="w-full border-gray-300">
        </div>
    </div>

    <div>
        <label class="block text-xs font-bold uppercase mb-1">Opening Hours</label>
        <textarea name="opening_hours" rows="3" class="w-full border-gray-300">{{ $settings->opening_hours }}</textarea>
    </div>

    <div>
        <label class="block text-xs font-bold uppercase mb-1">Google Maps Embed URL</label>
        <input type="text" name="google_maps_embed" value="{{ $settings->google_maps_embed }}" class="w-full border-gray-300">
    </div>

    <button type="submit" class="bg-[#173C32] text-[#C6A15B] px-8 py-3 text-xs uppercase tracking-widest font-bold">
        Save Restaurant Settings
    </button>
</form>
@endsection