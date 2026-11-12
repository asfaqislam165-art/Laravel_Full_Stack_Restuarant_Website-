<?php

namespace App\Providers;

use App\Models\RestaurantSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Schema::hasTable('restaurant_settings')) {
                $view->with('siteSettings', RestaurantSetting::current());
            }
            $cart = session()->get('cart', []);
            $cartCount = array_sum(array_column($cart, 'quantity'));
            $view->with('globalCartCount', $cartCount);
        });
    }
}