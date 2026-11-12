@extends('layouts.admin')

@section('content')
<h1 class="text-3xl font-bold text-[#173C32] mb-6">Create Manual Phone / WhatsApp Order</h1>

<form action="{{ route('admin.manual-orders.store') }}" method="POST" class="bg-white p-8 shadow-sm space-y-6 max-w-4xl">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Customer Name *</label>
            <input type="text" name="customer_name" required class="w-full border-gray-300">
        </div>
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Phone Number *</label>
            <input type="text" name="phone" required class="w-full border-gray-300">
        </div>
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Order Type *</label>
            <select name="order_type" class="w-full border-gray-300">
                <option value="delivery">Delivery (Cash on Delivery)</option>
                <option value="pickup">Pickup (Pay at Pickup)</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="md:col-span-2">
            <label class="block text-xs font-bold uppercase mb-1">Delivery Address</label>
            <input type="text" name="address" class="w-full border-gray-300">
        </div>
        <div>
            <label class="block text-xs font-bold uppercase mb-1">City</label>
            <input type="text" name="city" value="New York" class="w-full border-gray-300">
        </div>
        <div>
            <label class="block text-xs font-bold uppercase mb-1">ZIP Code</label>
            <input type="text" name="zip_code" class="w-full border-gray-300">
        </div>
    </div>

    <!-- Dynamic Dish Selection -->
    <div>
        <div class="flex justify-between items-center mb-2">
            <label class="text-xs font-bold uppercase">Select Dishes *</label>
            <button type="button" onclick="addItemRow()" class="bg-[#244D40] text-white px-3 py-1 text-xs font-bold">+ Add Dish</button>
        </div>
        <div id="itemsContainer" class="space-y-2">
            <div class="flex gap-3">
                <select name="items[0][menu_item_id]" required class="flex-1 border-gray-300 text-sm">
                    @foreach($menuItems as $item)
                        <option value="{{ $item->id }}">{{ $item->name }} (${{ number_format($item->price, 2) }})</option>
                    @endforeach
                </select>
                <input type="number" name="items[0][quantity]" value="1" min="1" required class="w-24 border-gray-300 text-sm">
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Discount ($)</label>
            <input type="number" step="0.01" name="discount" value="0" class="w-full border-gray-300">
        </div>
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Delivery Fee ($)</label>
            <input type="number" step="0.01" name="delivery_fee" value="{{ $settings->delivery_fee }}" class="w-full border-gray-300">
        </div>
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Order Notes</label>
            <input type="text" name="order_notes" class="w-full border-gray-300">
        </div>
    </div>

    <button type="submit" class="bg-[#173C32] text-[#C6A15B] px-8 py-3 text-xs uppercase tracking-widest font-bold">
        Save Manual Order
    </button>
</form>

<script>
    let rowIndex = 1;
    function addItemRow() {
        const container = document.getElementById('itemsContainer');
        const div = document.createElement('div');
        div.className = 'flex gap-3';
        div.innerHTML = `
            <select name="items[${rowIndex}][menu_item_id]" required class="flex-1 border-gray-300 text-sm">
                @foreach($menuItems as $item)
                    <option value="{{ $item->id }}">{{ addslashes($item->name) }} (${{ number_format($item->price, 2) }})</option>
                @endforeach
            </select>
            <input type="number" name="items[${rowIndex}][quantity]" value="1" min="1" required class="w-24 border-gray-300 text-sm">
        `;
        container.appendChild(div);
        rowIndex++;
    }
</script>
@endsection