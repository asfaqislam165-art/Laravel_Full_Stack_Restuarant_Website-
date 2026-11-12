<?php

// app/Http/Controllers/Admin/ReservationController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::latest();
        if ($request->filled('search')) {
            $query->where('customer_name', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%");
        }
        if ($request->filled('date')) {
            $query->whereDate('reservation_date', $request->date);
        }
        $reservations = $query->paginate(15)->withQueryString();
        return view('admin.reservations.index', compact('reservations'));
    }

    public function updateStatus(Request $request, Reservation $reservation)
    {
        $request->validate(['status' => 'required|in:Pending,Approved,Rejected,Completed']);
        $reservation->update(['status' => $request->status]);
        return back()->with('success', 'Reservation status updated.');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return back()->with('success', 'Reservation deleted.');
    }
}