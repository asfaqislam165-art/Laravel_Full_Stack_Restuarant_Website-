<!-- resources/views/admin/offers/index.blade.php -->
@extends('layouts.admin')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-[#173C32]">Special Offers</h1>
    <a href="{{ route('admin.offers.create') }}" class="bg-[#173C32] text-[#C6A15B] px-5 py-2.5 text-xs uppercase font-bold">+ Create Offer</a>
</div>
<div class="bg-white p-6 shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="border-b text-xs uppercase text-gray-500">
            <tr><th class="py-3">Title</th><th>Code</th><th>Discount</th><th>Valid Dates</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody class="divide-y">
            @foreach($offers as $offer)
            <tr>
                <td class="py-3 font-bold">{{ $offer->title }}</td>
                <td class="font-mono font-bold text-[#173C32]">{{ $offer->code }}</td>
                <td>{{ $offer->discount_type === 'percentage' ? $offer->discount_value.'%' : '$'.$offer->discount_value }}</td>
                <td>{{ $offer->start_date->format('M d') }} - {{ $offer->end_date->format('M d, Y') }}</td>
                <td>{{ $offer->is_active ? 'Active' : 'Inactive' }}</td>
                <td class="flex gap-3 py-3">
                    <a href="{{ route('admin.offers.edit', $offer) }}" class="text-blue-700 underline">Edit</a>
                    <form action="{{ route('admin.offers.destroy', $offer) }}" method="POST">
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