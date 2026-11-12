<!-- resources/views/admin/reservations/index.blade.php -->
@extends('layouts.admin')
@section('content')
<h1 class="text-3xl font-bold text-[#173C32] mb-6">Table Reservations</h1>
<div class="bg-white p-6 shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="border-b text-xs uppercase text-gray-500">
            <tr><th class="py-3">Guest</th><th>Date & Time</th><th>Party</th><th>Status</th><th>Update</th></tr>
        </thead>
        <tbody class="divide-y">
            @foreach($reservations as $res)
            <tr>
                <td class="py-3 font-bold">{{ $res->customer_name }}<br><span class="text-xs font-normal text-gray-500">{{ $res->phone }} | {{ $res->email }}</span></td>
                <td>{{ $res->reservation_date->format('M d, Y') }} at {{ $res->reservation_time }}</td>
                <td>{{ $res->guests }} Guests</td>
                <td class="font-bold">{{ $res->status }}</td>
                <td>
                    <form action="{{ route('admin.reservations.updateStatus', $res) }}" method="POST" class="flex gap-2">
                        @csrf @method('PATCH')
                        <select name="status" class="border-gray-300 text-xs">
                            @foreach(['Pending', 'Approved', 'Rejected', 'Completed'] as $st)
                                <option value="{{ $st }}" @selected($res->status === $st)>{{ $st }}</option>
                            @endforeach
                        </select>
                        <button class="bg-[#173C32] text-white px-3 py-1 text-xs font-bold">Save</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection