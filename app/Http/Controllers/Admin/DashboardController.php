<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Reservation;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('order_status', 'Pending')->count(),
            'confirmed_orders' => Order::where('order_status', 'Confirmed')->count(),
            'preparing_orders' => Order::where('order_status', 'Preparing')->count(),
            'completed_orders' => Order::where('order_status', 'Completed')->count(),
            'total_reservations' => Reservation::count(),
            'new_messages' => ContactMessage::where('is_read', false)->count(),
            'paid_orders' => Order::where('payment_status', 'Paid')->count(),
            'unpaid_orders' => Order::where('payment_status', 'Unpaid')->count(),
        ];

        // গত ৬ মাসের আসল অর্ডারের হিসাব (Chart.js এর জন্য)
        $chartLabels = [];
        $chartOrderCounts = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $chartLabels[] = $month->format('M');
            $chartOrderCounts[] = Order::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        $recentOrders = Order::with('items')->latest()->take(15)->get();
        $recentReservations = Reservation::latest()->take(6)->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'recentReservations',
            'chartLabels',
            'chartOrderCounts'
        ));
    }
}