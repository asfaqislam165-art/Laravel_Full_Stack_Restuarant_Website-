<!-- resources/views/admin/menu-items/create.blade.php (Use same fields for edit.blade.php) -->
@extends('layouts.admin')
@section('content')
<h1 class="text-3xl font-bold text-[#173C32] mb-6">Add Menu Dish</h1>
<form action="{{ route('admin.menu-items.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 max-w-2xl shadow-sm space-y-4">
    @csrf
    <div>
        <label class="block text-xs font-bold uppercase mb-1">Category *</label>
        <select name="category_id" required class="w-full border-gray-300">
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Dish Name *</label>
            <input type="text" name="name" required class="w-full border-gray-300">
        </div>
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Price ($) *</label>
            <input type="number" step="0.01" name="price" required class="w-full border-gray-300">
        </div>
    </div>
    <div>
        <label class="block text-xs font-bold uppercase mb-1">Description</label>
        <textarea name="description" rows="3" class="w-full border-gray-300"></textarea>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Prep Time</label>
            <input type="text" name="prep_time" placeholder="20-25 mins" class="w-full border-gray-300">
        </div>
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Dietary Tags</label>
            <input type="text" name="dietary_tags" placeholder="USDA Prime, Gluten-Free" class="w-full border-gray-300">
        </div>
    </div>
    <div>
        <label class="block text-xs font-bold uppercase mb-1">Dish Image</label>
        <input type="file" name="image" class="w-full text-sm">
    </div>
    <div class="flex gap-6 text-sm">
        <label><input type="checkbox" name="is_featured" value="1"> Featured Dish</label>
        <label><input type="checkbox" name="is_popular" value="1"> Popular Dish</label>
        <label><input type="checkbox" name="is_available" value="1" checked> Available</label>
    </div>
    <button type="submit" class="bg-[#173C32] text-[#C6A15B] px-6 py-3 text-xs uppercase font-bold">Save Dish</button>
</form>
@endsection