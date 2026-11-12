<!-- resources/views/admin/messages/index.blade.php -->
@extends('layouts.admin')
@section('content')
<h1 class="text-3xl font-bold text-[#173C32] mb-6">Contact Messages</h1>
<div class="bg-white p-6 shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="border-b text-xs uppercase text-gray-500">
            <tr><th class="py-3">From</th><th>Subject</th><th>Status</th><th>Date</th><th>Actions</th></tr>
        </thead>
        <tbody class="divide-y">
            @foreach($messages as $msg)
            <tr class="{{ !$msg->is_read ? 'bg-amber-50/50 font-semibold' : '' }}">
                <td class="py-3">{{ $msg->name }}<br><span class="text-xs text-gray-500">{{ $msg->email }}</span></td>
                <td>{{ $msg->subject }}</td>
                <td>{{ $msg->is_read ? 'Read' : 'New' }}</td>
                <td>{{ $msg->created_at->format('M d, Y') }}</td>
                <td class="flex gap-3 py-3">
                    <a href="{{ route('admin.messages.show', $msg) }}" class="text-[#173C32] underline">Read</a>
                    <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST">
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