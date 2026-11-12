@extends('layouts.admin')

@section('content')
<h1 class="text-3xl font-bold text-[#173C32] mb-6">Edit Category: {{ $category->name }}</h1>

<form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 max-w-xl shadow-sm space-y-4">
    @csrf @method('PUT')
    <div>
        <label class="block text-xs font-bold uppercase mb-1">Category Name *</label>
        <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="w-full border-gray-300">
    </div>

    <div>
        <label class="block text-xs font-bold uppercase mb-1">Description</label>
        <textarea name="description" rows="3" class="w-full border-gray-300">{{ old('description', $category->description) }}</textarea>
    </div>

    <div>
        <label class="block text-xs font-bold uppercase mb-1">Category Image</label>
        @if($category->image)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-24 h-24 object-cover border">
            </div>
        @endif
        <input type="file" name="image" class="w-full text-sm">
    </div>

    <div>
        <label class="block text-xs font-bold uppercase mb-1">Sort Order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" class="w-full border-gray-300">
    </div>

    <label class="inline-flex items-center gap-2 text-sm pt-2">
        <input type="checkbox" name="is_active" value="1" @checked($category->is_active)> Active Category
    </label>

    <div class="pt-4">
        <button type="submit" class="bg-[#173C32] text-[#C6A15B] px-6 py-3 text-xs uppercase font-bold tracking-widest">
            Update Category
        </button>
    </div>
</form>
@endsection