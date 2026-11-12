<!-- resources/views/admin/reviews/index.blade.php -->
@extends('layouts.admin')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-[#173C32]">Admin-Managed Reviews</h1>
    <a href="{{ route('admin.reviews.create') }}" class="bg-[#173C32] text-[#C6A15B] px-5 py-2.5 text-xs uppercase font-bold">+ Add Review</a>
</div>
<div class="bg-white p-6 shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="border-b text-xs uppercase text-gray-500">
            <tr><th class="py-3">Reviewer</th><th>Rating</th><th>Review</th><th>Published</th><th>Actions</th></tr>
        </thead>
        <tbody class="divide-y">
            @foreach($reviews as $rev)
            <tr>
                <td class="py-3 font-bold">{{ $rev->reviewer_name }}</td>
                <td class="text-[#C6A15B]">{{ str_repeat('★', $rev->rating) }}</td>
                <td class="max-w-md truncate">{{ $rev->review_text }}</td>
                <td>{{ $rev->is_published ? 'Published' : 'Hidden' }}</td>
                <td class="flex gap-3 py-3">
                    <a href="{{ route('admin.reviews.edit', $rev) }}" class="text-blue-700 underline">Edit</a>
                    <form action="{{ route('admin.reviews.destroy', $rev) }}" method="POST">
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