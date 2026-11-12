<!-- resources/views/admin/categories/index.blade.php -->
@extends('layouts.admin')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-[#173C32]">Menu Categories</h1>
    <a href="{{ route('admin.categories.create') }}" class="bg-[#173C32] text-[#C6A15B] px-5 py-2.5 text-xs uppercase font-bold">+ Add Category</a>
</div>
<div class="bg-white p-6 shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="border-b text-xs uppercase text-gray-500">
            <tr><th class="py-3">Name</th><th>Dishes</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody class="divide-y">
            @foreach($categories as $cat)
            <tr>
                <td class="py-3 font-bold">{{ $cat->name }}</td>
                <td>{{ $cat->menu_items_count }}</td>
                <td>{{ $cat->is_active ? 'Active' : 'Inactive' }}</td>
                <td class="flex gap-3 py-3">
                    <a href="{{ route('admin.categories.edit', $cat) }}" class="text-blue-700 underline">Edit</a>
                    <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="text-red-700 underline">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection