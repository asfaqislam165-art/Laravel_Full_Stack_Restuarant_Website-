<?php

// app/Http/Controllers/Admin/SpecialOfferController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpecialOffer;
use Illuminate\Http\Request;

class SpecialOfferController extends Controller
{
    public function index()
    {
        $offers = SpecialOffer::latest()->paginate(15);
        return view('admin.offers.index', compact('offers'));
    }

    public function create() { return view('admin.offers.create'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'code' => 'required|string|max:30|unique:special_offers,code',
            'description' => 'nullable|string|max:500',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0.01',
            'min_order_amount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        $data['code'] = strtoupper(trim($data['code']));
        $data['min_order_amount'] = $data['min_order_amount'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');
        SpecialOffer::create($data);
        return redirect()->route('admin.offers.index')->with('success', 'Special offer created.');
    }

    public function edit(SpecialOffer $offer) { return view('admin.offers.edit', compact('offer')); }

    public function update(Request $request, SpecialOffer $offer)
    {
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'code' => 'required|string|max:30|unique:special_offers,code,' . $offer->id,
            'description' => 'nullable|string|max:500',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0.01',
            'min_order_amount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        $data['code'] = strtoupper(trim($data['code']));
        $data['is_active'] = $request->boolean('is_active');
        $offer->update($data);
        return redirect()->route('admin.offers.index')->with('success', 'Special offer updated.');
    }

    public function destroy(SpecialOffer $offer)
    {
        $offer->delete();
        return back()->with('success', 'Special offer deleted.');
    }
}