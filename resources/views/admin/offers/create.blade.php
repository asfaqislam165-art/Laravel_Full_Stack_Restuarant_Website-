@extends('layouts.admin')

@section('content')
<h1 class="text-3xl font-bold text-[#173C32] mb-6">Create Special Offer</h1>

<form action="{{ route('admin.offers.store') }}" method="POST" class="bg-white p-8 shadow-sm max-w-2xl space-y-4">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Offer Title *</label>
            <input type="text" name="title" value="{{ old('title') }}" required class="w-full border-gray-300">
        </div>
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Promo Code *</label>
            <input type="text" name="code" value="{{ old('code') }}" placeholder="e.g., OAK15" required class="w-full border-gray-300 uppercase">
        </div>
    </div>

    <div>
        <label class="block text-xs font-bold uppercase mb-1">Description</label>
        <textarea name="description" rows="3" class="w-full border-gray-300">{{ old('description') }}</textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Discount Type *</label>
            <select name="discount_type" class="w-full border-gray-300">
                <option value="percentage">Percentage (%)</option>
                <option value="fixed">Fixed Amount ($)</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Discount Value *</label>
            <input type="number" step="0.01" name="discount_value" value="{{ old('discount_value', 15) }}" required class="w-full border-gray-300">
        </div>
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Min. Order Amount ($)</label>
            <input type="number" step="0.01" name="min_order_amount" value="{{ old('min_order_amount', 50) }}" class="w-full border-gray-300">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Start Date *</label>
            <input type="date" name="start_date" value="{{ date('Y-m-d') }}" required class="w-full border-gray-300">
        </div>
        <div>
            <label class="block text-xs font-bold uppercase mb-1">End Date *</label>
            <input type="date" name="end_date" value="{{ date('Y-m-d', strtotime('+3 months')) }}" required class="w-full border-gray-300">
        </div>
    </div>

    <label class="inline-flex items-center gap-2 text-sm pt-2">
        <input type="checkbox" name="is_active" value="1" checked> Active Offer
    </label>

    <div class="pt-4">
        <button type="submit" class="bg-[#173C32] text-[#C6A15B] px-6 py-3 text-xs uppercase font-bold tracking-widest">
            Save Special Offer
        </button>
    </div>
</form>
@endsection