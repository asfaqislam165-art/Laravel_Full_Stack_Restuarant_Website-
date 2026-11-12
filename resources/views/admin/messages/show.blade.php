@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.messages.index') }}" class="text-xs text-gray-500 hover:underline">&larr; Back to Messages</a>
    <h1 class="text-3xl font-bold text-[#173C32] mt-1">Message from {{ $message->name }}</h1>
</div>

<div class="bg-white p-8 shadow-sm max-w-3xl space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-b pb-4 text-sm">
        <div>
            <p class="text-xs uppercase text-gray-400 font-bold">Email Address</p>
            <p class="font-semibold"><a href="mailto:{{ $message->email }}" class="text-[#173C32] underline">{{ $message->email }}</a></p>
        </div>
        <div>
            <p class="text-xs uppercase text-gray-400 font-bold">Phone Number</p>
            <p class="font-semibold">{{ $message->phone ?? 'Not provided' }}</p>
        </div>
    </div>

    <div>
        <p class="text-xs uppercase text-gray-400 font-bold mb-1">Subject</p>
        <p class="text-lg font-serif-luxury font-bold text-[#173C32]">{{ $message->subject }}</p>
    </div>

    <div>
        <p class="text-xs uppercase text-gray-400 font-bold mb-1">Message Content</p>
        <div class="bg-ivory p-4 border border-[#173C32]/10 text-sm leading-relaxed whitespace-pre-line">
            {{ $message->message }}
        </div>
    </div>

    <div class="flex items-center justify-between pt-4 border-t">
        <span class="text-xs text-gray-500">Received on {{ $message->created_at->format('M d, Y at h:i A') }}</span>
        <div class="flex gap-3">
            @if($message->phone)
            <a href="tel:{{ $message->phone }}" class="bg-[#173C32] text-white px-4 py-2 text-xs uppercase font-bold">Call Customer</a>
            @endif
            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Delete this message?')">
                @csrf @method('DELETE')
                <button class="bg-red-800 text-white px-4 py-2 text-xs uppercase font-bold">Delete Message</button>
            </form>
        </div>
    </div>
</div>
@endsection