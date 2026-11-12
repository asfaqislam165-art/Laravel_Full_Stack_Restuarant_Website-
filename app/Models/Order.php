<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'customer_name', 'phone', 'whatsapp', 'email',
        'order_type', 'address', 'city', 'state', 'zip_code',
        'delivery_instructions', 'order_notes', 'offer_code',
        'subtotal', 'discount', 'delivery_fee', 'total',
        'payment_method', 'payment_status', 'order_status', 'is_manual'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'total' => 'decimal:2',
        'is_manual' => 'boolean',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Generates a pre-filled WhatsApp Click-to-Chat URL
     */
    public function getWhatsappUrl(string $targetPhone): string
    {
        $cleanPhone = preg_replace('/[^0-9]/', '', $targetPhone);
        $lines = [
            "*NEW ORDER - {$this->order_number}*",
            "Customer: {$this->customer_name}",
            "Phone: {$this->phone}",
            "Type: " . strtoupper($this->order_type),
        ];

        if ($this->order_type === 'delivery') {
            $lines[] = "Address: {$this->address}, {$this->city}, {$this->state} {$this->zip_code}";
        }

        $lines[] = "\n*Ordered Items:*";
        foreach ($this->items as $item) {
            $lines[] = "• {$item->quantity}x {$item->item_name} ($" . number_format($item->total_price, 2) . ")";
        }

        $lines[] = "\nSubtotal: $" . number_format($this->subtotal, 2);
        if ($this->discount > 0) {
            $lines[] = "Discount: -$" . number_format($this->discount, 2);
        }
        if ($this->delivery_fee > 0) {
            $lines[] = "Delivery Fee: $" . number_format($this->delivery_fee, 2);
        }
        $lines[] = "*Final Total: $" . number_format($this->total, 2) . "*";
        $lines[] = "Payment: {$this->payment_method} ({$this->payment_status})";

        return "https://wa.me/{$cleanPhone}?text=" . urlencode(implode("\n", $lines));
    }
}