@extends('layouts.admin')

@section('content')
<h1 class="text-3xl font-bold text-[#173C32] mb-6">Edit Dish: {{ $menuItem->name }}</h1>

<form action="{{ route('admin.menu-items.update', $menuItem) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 max-w-2xl shadow-sm space-y-4">
    @csrf @method('PUT')
    <div>
        <label class="block text-xs font-bold uppercase mb-1">Category *</label>
        <select name="category_id" required class="w-full border-gray-300">
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected($menuItem->category_id === $cat->id)>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Dish Name *</label>
            <input type="text" name="name" value="{{ old('name', $menuItem->name) }}" required class="w-full border-gray-300">
        </div>
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Price ($) *</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $menuItem->price) }}" required class="w-full border-gray-300">
        </div>
    </div>

    <div>
        <label class="block text-xs font-bold uppercase mb-1">Description</label>
        <textarea name="description" rows="3" class="w-full border-gray-300">{{ old('description', $menuItem->description) }}</textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Prep Time</label>
            <input type="text" name="prep_time" value="{{ old('prep_time', $menuItem->prep_time) }}" class="w-full border-gray-300">
        </div>
        <div>
            <label class="block text-xs font-bold uppercase mb-1">Dietary Tags</label>
            <input type="text" name="dietary_tags" value="{{ old('dietary_tags', $menuItem->dietary_tags) }}" class="w-full border-gray-300">
        </div>
    </div>

    <div>
        <label class="block text-xs font-bold uppercase mb-1">Dish Image</label>
        @if($menuItem->image)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $menuItem->image) }}" alt="{{ $menuItem->name }}" class="w-24 h-24 object-cover border">
            </div>
        @endif
        <input type="file" name="image" class="w-full text-sm">
    </div>

    <div class="flex flex-wrap gap-6 text-sm pt-2">
        <label class="inline-flex items-center gap-2"><input type="checkbox" name="is_featured" value="1" @checked($menuItem->is_featured)> Featured Dish</label>
        <label class="inline-flex items-center gap-2"><input type="checkbox" name="is_popular" value="1" @checked($menuItem->is_popular)> Popular Dish</label>
        <label class="inline-flex items-center gap-2"><input type="checkbox" name="is_available" value="1" @checked($menuItem->is_available)> Available</label>
    </div>

    <div class="pt-4">
        <button type="submit" class="bg-[#173C32] text-[#C6A15B] px-6 py-3 text-xs uppercase font-bold tracking-widest">
            Update Menu Dish
        </button>
    </div>
</form>
@endsection