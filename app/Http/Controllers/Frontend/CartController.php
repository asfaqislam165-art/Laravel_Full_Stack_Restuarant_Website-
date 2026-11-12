<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\RestaurantSetting;
use App\Models\SpecialOffer;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $summary = $this->calculateCartSummary();
        return view('frontend.cart', $summary);
    }

    public function add(Request $request, MenuItem $menuItem)
    {
        if (!$menuItem->is_available) {
            return back()->with('error', 'Sorry, this dish is currently unavailable.');
        }

        $qty = max(1, (int) $request->input('quantity', 1));
        $cart = session()->get('cart', []);

        if (isset($cart[$menuItem->id])) {
            $cart[$menuItem->id]['quantity'] += $qty;
        } else {
            $cart[$menuItem->id] = [
                'id' => $menuItem->id,
                'name' => $menuItem->name,
                'price' => (float) $menuItem->price,
                'image' => $menuItem->image,
                'quantity' => $qty,
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', "{$menuItem->name} added to your order.");
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $cart = session()->get('cart', []);
        $action = $request->input('action');

        if (isset($cart[$menuItem->id])) {
            if ($action === 'increase') {
                $cart[$menuItem->id]['quantity']++;
            } elseif ($action === 'decrease') {
                if ($cart[$menuItem->id]['quantity'] > 1) {
                    $cart[$menuItem->id]['quantity']--;
                } else {
                    unset($cart[$menuItem->id]);
                }
            }
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Cart updated.');
    }

    public function remove(MenuItem $menuItem)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$menuItem->id])) {
            unset($cart[$menuItem->id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Item removed from cart.');
    }

    public function applyOffer(Request $request)
    {
        $request->validate(['offer_code' => 'required|string']);
        $offer = SpecialOffer::currentlyValid()
            ->where('code', strtoupper(trim($request->offer_code)))
            ->first();

        if (!$offer) {
            return back()->with('error', 'Invalid or expired promotional code.');
        }

        session()->put('applied_offer_code', $offer->code);
        return back()->with('success', "Promo code {$offer->code} applied!");
    }

    public function removeOffer()
    {
        session()->forget('applied_offer_code');
        return back()->with('success', 'Promotional code removed.');
    }

    public function calculateCartSummary(string $orderType = 'delivery'): array
    {
        $sessionCart = session()->get('cart', []);
        $settings = RestaurantSetting::current();
        $validatedCart = [];
        $subtotal = 0;

        // Re-verify live prices and availability from DB
        foreach ($sessionCart as $id => $item) {
            $dbItem = MenuItem::find($id);
            if ($dbItem && $dbItem->is_available) {
                $lineTotal = round($dbItem->price * $item['quantity'], 2);
                $validatedCart[$id] = [
                    'id' => $dbItem->id,
                    'name' => $dbItem->name,
                    'price' => (float) $dbItem->price,
                    'image' => $dbItem->image,
                    'quantity' => $item['quantity'],
                    'line_total' => $lineTotal,
                ];
                $subtotal += $lineTotal;
            }
        }
        session()->put('cart', $validatedCart);

        $discount = 0;
        $appliedOffer = null;
        if ($code = session()->get('applied_offer_code')) {
            $appliedOffer = SpecialOffer::currentlyValid()->where('code', $code)->first();
            if ($appliedOffer) {
                $discount = $appliedOffer->calculateDiscount($subtotal);
            } else {
                session()->forget('applied_offer_code');
            }
        }

        $deliveryFee = ($orderType === 'delivery' && $subtotal > 0) ? (float) $settings->delivery_fee : 0;
        $total = max(0, round($subtotal - $discount + $deliveryFee, 2));

        return compact('validatedCart', 'subtotal', 'discount', 'deliveryFee', 'total', 'appliedOffer', 'settings');
    }
}