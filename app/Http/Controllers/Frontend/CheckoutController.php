<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\RestaurantSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(CartController $cartController)
    {
        $summary = $cartController->calculateCartSummary('delivery');
        if (empty($summary['validatedCart'])) {
            return redirect()->route('menu')->with('error', 'Your cart is empty. Please add items before checking out.');
        }

        return view('frontend.checkout', $summary);
    }

    public function store(CheckoutRequest $request, CartController $cartController)
    {
        $summary = $cartController->calculateCartSummary($request->order_type);

        if (empty($summary['validatedCart'])) {
            return redirect()->route('menu')->with('error', 'Your cart is empty or items became unavailable.');
        }

        if ($request->order_type === 'delivery' && $summary['subtotal'] < $summary['settings']->minimum_order_amount) {
            return back()->withInput()->with('error', 'Minimum order amount for delivery is $' . number_format($summary['settings']->minimum_order_amount, 2));
        }

        // Enforce manual payment method matching order type
        $paymentMethod = $request->order_type === 'delivery' ? 'Cash on Delivery' : 'Pay at Pickup';

        $order = DB::transaction(function () use ($request, $summary, $paymentMethod) {
            $orderNumber = 'EO-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            $order = Order::create([
                'order_number' => $orderNumber,
                'customer_name' => $request->customer_name,
                'phone' => $request->phone,
                'whatsapp' => $request->whatsapp,
                'email' => $request->email,
                'order_type' => $request->order_type,
                'address' => $request->order_type === 'delivery' ? $request->address : null,
                'city' => $request->order_type === 'delivery' ? $request->city : null,
                'state' => $request->order_type === 'delivery' ? $request->state : null,
                'zip_code' => $request->order_type === 'delivery' ? $request->zip_code : null,
                'delivery_instructions' => $request->delivery_instructions,
                'order_notes' => $request->order_notes,
                'offer_code' => $summary['appliedOffer']?->code,
                'subtotal' => $summary['subtotal'],
                'discount' => $summary['discount'],
                'delivery_fee' => $summary['deliveryFee'],
                'total' => $summary['total'],
                'payment_method' => $paymentMethod,
                'payment_status' => 'Unpaid',
                'order_status' => 'Pending',
                'is_manual' => false,
            ]);

            foreach ($summary['validatedCart'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $item['id'],
                    'item_name' => $item['name'],
                    'unit_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'total_price' => $item['line_total'],
                ]);
            }

            return $order;
        });

        session()->forget(['cart', 'applied_offer_code']);

        return redirect()->route('order.confirmation', $order->order_number)
            ->with('success', 'Your order has been received!');
    }

    public function confirmation(Order $order)
    {
        $order->load('items');
        $settings = RestaurantSetting::current();
        $whatsappUrl = $order->getWhatsappUrl($settings->whatsapp);

        return view('frontend.order-confirmation', compact('order', 'settings', 'whatsappUrl'));
    }
}