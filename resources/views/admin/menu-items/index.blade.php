<!-- resources/views/admin/menu-items/index.blade.php -->
@extends('layouts.admin')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-[#173C32]">Menu Items</h1>
    <a href="{{ route('admin.menu-items.create') }}" class="bg-[#173C32] text-[#C6A15B] px-5 py-2.5 text-xs uppercase font-bold">+ Add Dish</a>
</div>
<div class="bg-white p-6 shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="border-b text-xs uppercase text-gray-500">
            <tr><th class="py-3">Dish</th><th>Category</th><th>Price</th><th>Featured</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody class="divide-y">
            @foreach($items as $item)
            <tr>
                <td class="py-3 font-bold">{{ $item->name }}</td>
                <td>{{ $item->category->name }}</td>
                <td>${{ number_format($item->price, 2) }}</td>
                <td>{{ $item->is_featured ? 'Yes' : 'No' }}</td>
                <td>{{ $item->is_available ? 'Available' : 'Sold Out' }}</td>
                <td class="flex gap-3 py-3">
                    <a href="{{ route('admin.menu-items.edit', $item) }}" class="text-blue-700 underline">Edit</a>
                    <form action="{{ route('admin.menu-items.destroy', $item) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="text-red-700 underline">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">{{ $items->links() }}</div>
</div>
@endsection