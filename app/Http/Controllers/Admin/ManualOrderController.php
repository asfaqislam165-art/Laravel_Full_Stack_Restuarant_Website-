<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\RestaurantSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ManualOrderController extends Controller
{
    public function create()
    {
        $menuItems = MenuItem::where('is_available', true)->orderBy('name')->get();
        $settings = RestaurantSetting::current();
        return view('admin.orders.manual-create', compact('menuItems', 'settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:120',
            'phone' => 'required|string|max:25',
            'whatsapp' => 'nullable|string|max:25',
            'order_type' => 'required|in:delivery,pickup',
            'address' => 'required_if:order_type,delivery|nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:50',
            'zip_code' => 'nullable|string|max:20',
            'discount' => 'nullable|numeric|min:0',
            'delivery_fee' => 'nullable|numeric|min:0',
            'order_notes' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = DB::transaction(function () use ($request) {
            $subtotal = 0;
            $lineItems = [];

            foreach ($request->items as $row) {
                $menuItem = MenuItem::findOrFail($row['menu_item_id']);
                $lineTotal = round($menuItem->price * $row['quantity'], 2);
                $subtotal += $lineTotal;
                $lineItems[] = [
                    'menu_item_id' => $menuItem->id,
                    'item_name' => $menuItem->name,
                    'unit_price' => $menuItem->price,
                    'quantity' => $row['quantity'],
                    'total_price' => $lineTotal,
                ];
            }

            $discount = (float) ($request->discount ?? 0);
            $deliveryFee = $request->order_type === 'delivery' ? (float) ($request->delivery_fee ?? 0) : 0;
            $total = max(0, round($subtotal - $discount + $deliveryFee, 2));
            $paymentMethod = $request->order_type === 'delivery' ? 'Cash on Delivery' : 'Pay at Pickup';

            $order = Order::create([
                'order_number' => 'EO-M-' . date('Ymd') . '-' . strtoupper(Str::random(4)),
                'customer_name' => $request->customer_name,
                'phone' => $request->phone,
                'whatsapp' => $request->whatsapp,
                'order_type' => $request->order_type,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'order_notes' => $request->order_notes,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'payment_method' => $paymentMethod,
                'payment_status' => 'Unpaid',
                'order_status' => 'Confirmed',
                'is_manual' => true,
            ]);

            foreach ($lineItems as $item) {
                $order->items()->create($item);
            }

            return $order;
        });

        return redirect()->route('admin.orders.show', $order)
            ->with('success', "Manual phone/WhatsApp order {$order->order_number} created successfully.");
    }
}