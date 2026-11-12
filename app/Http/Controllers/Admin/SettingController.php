<?php

// app/Http/Controllers/Admin/SettingController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RestaurantSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = RestaurantSetting::current();
        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'restaurant_name' => 'required|string|max:120',
            'tagline' => 'nullable|string|max:200',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'phone' => 'required|string|max:30',
            'whatsapp' => 'required|string|max:30',
            'email' => 'required|email|max:120',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:50',
            'zip_code' => 'required|string|max:20',
            'opening_hours' => 'nullable|string|max:500',
            'delivery_fee' => 'required|numeric|min:0',
            'minimum_order_amount' => 'required|numeric|min:0',
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'google_maps_embed' => 'nullable|string',
        ]);

        $settings = RestaurantSetting::current();
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('branding', 'public');
        }
        $settings->update($data);

        return back()->with('success', 'Restaurant settings updated successfully.');
    }
}