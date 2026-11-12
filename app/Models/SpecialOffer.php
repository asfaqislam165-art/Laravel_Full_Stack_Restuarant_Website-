<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SpecialOffer extends Model
{
    protected $fillable = [
        'title', 'code', 'description', 'discount_type',
        'discount_value', 'min_order_amount', 'start_date', 'end_date', 'is_active'
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function scopeCurrentlyValid($query)
    {
        $today = Carbon::today();
        return $query->where('is_active', true)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today);
    }

    public function calculateDiscount(float $subtotal): float
    {
        if ($subtotal < $this->min_order_amount) {
            return 0;
        }
        if ($this->discount_type === 'percentage') {
            return round(($subtotal * $this->discount_value) / 100, 2);
        }
        return min($subtotal, (float) $this->discount_value);
    }
}