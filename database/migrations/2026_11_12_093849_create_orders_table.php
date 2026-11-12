<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique()->index();
            $table->string('customer_name');
            $table->string('phone')->index();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->enum('order_type', ['delivery', 'pickup']);
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->text('delivery_instructions')->nullable();
            $table->text('order_notes')->nullable();
            $table->string('offer_code')->nullable();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->enum('payment_method', ['Cash on Delivery', 'Pay at Pickup']);
            $table->enum('payment_status', ['Unpaid', 'Paid', 'Refunded'])->default('Unpaid');
            $table->enum('order_status', [
                'Pending',
                'Confirmed',
                'Preparing',
                'Ready for Pickup',
                'Out for Delivery',
                'Completed',
                'Cancelled'
            ])->default('Pending');
            $table->boolean('is_manual')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};