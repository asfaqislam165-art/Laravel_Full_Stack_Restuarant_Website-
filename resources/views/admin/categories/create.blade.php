<!-- resources/views/admin/categories/create.blade.php (Use same form structure for edit.blade.php) -->
@extends('layouts.admin')
@section('content')
<h1 class="text-3xl font-bold text-[#173C32] mb-6">Create Category</h1>
<form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 max-w-xl shadow-sm space-y-4">
    @csrf
    <div>
        <label class="block text-xs font-bold uppercase mb-1">Category Name *</label>
        <input type="text" name="name" required class="w-full border-gray-300">
    </div>
    <div>
        <label class="block text-xs font-bold uppercase mb-1">Description</label>
        <textarea name="description" class="w-full border-gray-300"></textarea>
    </div>
    <div>
        <label class="block text-xs font-bold uppercase mb-1">Category Image</label>
        <input type="file" name="image" class="w-full text-sm">
    </div>
    <label class="inline-flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_active" value="1" checked> Active
    </label>
    <div>
        <button type="submit" class="bg-[#173C32] text-[#C6A15B] px-6 py-3 text-xs uppercase font-bold">Save Category</button>
    </div>
</form>
@endsection