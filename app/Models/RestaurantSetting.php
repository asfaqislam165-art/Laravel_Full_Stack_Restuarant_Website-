<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class RestaurantSetting extends Model
{
    protected $fillable = [
        'restaurant_name', 'tagline', 'logo', 'phone', 'whatsapp', 'email',
        'address', 'city', 'state', 'zip_code', 'opening_hours',
        'delivery_fee', 'minimum_order_amount', 'facebook_url',
        'instagram_url', 'twitter_url', 'google_maps_embed'
    ];

    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }
}