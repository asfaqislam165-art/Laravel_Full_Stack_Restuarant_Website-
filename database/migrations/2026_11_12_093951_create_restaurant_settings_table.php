<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('restaurant_settings', function (Blueprint $table) {
            $table->id();
            $table->string('restaurant_name')->default('The Emerald Oak');
            $table->string('tagline')->default('Modern American Steakhouse & Fine Dining');
            $table->string('logo')->nullable();
            $table->string('phone')->default('+1 (212) 555-0194');
            $table->string('whatsapp')->default('12125550194'); // Digits only for wa.me
            $table->string('email')->default('concierge@emeraldoaknyc.com');
            $table->string('address')->default('428 Madison Avenue');
            $table->string('city')->default('New York');
            $table->string('state')->default('NY');
            $table->string('zip_code')->default('10017');
            $table->text('opening_hours')->nullable();
            $table->decimal('delivery_fee', 8, 2)->default(8.50);
            $table->decimal('minimum_order_amount', 8, 2)->default(25.00);
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->text('google_maps_embed')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurant_settings');
    }
};